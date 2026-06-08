<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Purchase;
use App\Models\Subscription;
use App\Models\Group;
use App\Models\GroupMessage;
use App\Models\ForumQuestion;
use App\Models\ForumAnswer;
use Illuminate\Support\Str;

class LessonViewer extends Component
{
    use WithFileUploads;

    public Course $course;
    public Lesson $lesson;
    
    // Status
    public $isCompleted = false;

    // Tabs: 'resources', 'chat', 'forum'
    public $activeTab = 'resources';

    // Group Chat fields
    public $chatMessage = '';

    // Forum Q&A fields
    public $showCreateQuestion = false;
    public $forumTitle = '';
    public $forumContent = '';
    public $selectedQuestionId = null;
    public $newAnswerContent = '';

    protected $rules = [
        'chatMessage' => 'required|string|max:1000',
    ];

    public function mount($courseSlug, $lessonSlug)
    {
        $this->course = Course::where('slug', $courseSlug)->firstOrFail();
        $this->lesson = Lesson::where('slug', $lessonSlug)->firstOrFail();

        // 1. Check access authorization
        $userId = auth()->id();
        $hasPurchase = Purchase::where('user_id', $userId)
            ->where('course_id', $this->course->id)
            ->where('status', 'approved')
            ->exists();

        $hasActiveSubscription = Subscription::where('user_id', $userId)
            ->where('status', 'active')
            ->where(function($query) {
                $query->whereNull('ends_at')
                      ->orWhere('ends_at', '>', now());
            })
            ->exists();

        $isAuthorized = $hasPurchase || $hasActiveSubscription || $this->lesson->is_free || auth()->user()->hasRole('admin');

        if (!$isAuthorized) {
            session()->flash('error', 'No tienes acceso a este curso. Adquiérelo o contrata una suscripción.');
            return redirect()->route('courses.detail', $this->course->slug);
        }

        // 2. Check completion status
        $this->isCompleted = $this->lesson->usersWhoCompleted()
            ->where('user_id', $userId)
            ->exists();

        // 3. Make sure the user is in the course group
        $group = $this->course->group;
        if ($group) {
            $group->users()->syncWithoutDetaching([$userId]);
        }
    }

    public function toggleCompleted()
    {
        $userId = auth()->id();
        
        if ($this->isCompleted) {
            $this->lesson->usersWhoCompleted()->detach($userId);
            $this->isCompleted = false;
        } else {
            $this->lesson->usersWhoCompleted()->attach($userId, ['completed_at' => now()]);
            $this->isCompleted = true;
        }
    }

    // Chat actions
    public function sendMessage()
    {
        $this->validate(['chatMessage' => 'required|string|max:1000']);

        $group = $this->course->group;
        if ($group) {
            GroupMessage::create([
                'group_id' => $group->id,
                'user_id' => auth()->id(),
                'content' => $this->chatMessage,
            ]);
            $this->chatMessage = '';
        }
    }

    // Forum actions
    public function openCreateQuestionForm()
    {
        $this->forumTitle = '';
        $this->forumContent = '';
        $this->showCreateQuestion = true;
        $this->selectedQuestionId = null;
    }

    public function createQuestion()
    {
        $this->validate([
            'forumTitle' => 'required|string|max:255',
            'forumContent' => 'required|string',
        ]);

        $group = $this->course->group;
        if ($group) {
            ForumQuestion::create([
                'group_id' => $group->id,
                'user_id' => auth()->id(),
                'title' => $this->forumTitle,
                'slug' => Str::slug($this->forumTitle) . '-' . uniqid(),
                'content' => $this->forumContent,
            ]);

            $this->showCreateQuestion = false;
            $this->forumTitle = '';
            $this->forumContent = '';
            session()->flash('forum_message', 'Pregunta publicada con éxito.');
        }
    }

    public function selectQuestion($id)
    {
        $this->selectedQuestionId = $id;
        $this->newAnswerContent = '';
        $this->showCreateQuestion = false;
    }

    public function createAnswer()
    {
        $this->validate([
            'newAnswerContent' => 'required|string',
        ]);

        ForumAnswer::create([
            'question_id' => $this->selectedQuestionId,
            'user_id' => auth()->id(),
            'content' => $this->newAnswerContent,
        ]);

        $this->newAnswerContent = '';
        session()->flash('forum_message', 'Respuesta agregada con éxito.');
    }

    public function closeQuestion()
    {
        $this->selectedQuestionId = null;
    }

    public function render()
    {
        $sections = $this->course->sections()->with('lessons')->get();
        $group = $this->course->group;

        $chatMessages = [];
        $forumQuestions = [];
        $activeQuestion = null;

        if ($group) {
            if ($this->activeTab === 'chat') {
                $chatMessages = GroupMessage::with('user')
                    ->where('group_id', $group->id)
                    ->oldest() // chronological order
                    ->take(50)
                    ->get();
            } elseif ($this->activeTab === 'forum') {
                if ($this->selectedQuestionId) {
                    $activeQuestion = ForumQuestion::with(['user', 'answers.user'])
                        ->findOrFail($this->selectedQuestionId);
                } else {
                    $forumQuestions = ForumQuestion::with('user')
                        ->withCount('answers')
                        ->where('group_id', $group->id)
                        ->latest()
                        ->get();
                }
            }
        }

        // Keep track of completed lesson IDs for syllabus checkbox rendering
        $completedLessons = auth()->user()
            ? auth()->user()->completedLessons()->pluck('lesson_id')->toArray()
            : [];

        return view('livewire.lesson-viewer', compact(
            'sections',
            'chatMessages',
            'forumQuestions',
            'activeQuestion',
            'completedLessons'
        ))->layout('layouts.student');
    }
}
