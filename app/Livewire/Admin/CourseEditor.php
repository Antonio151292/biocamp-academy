<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Course;
use App\Models\Section;
use App\Models\Lesson;

class CourseEditor extends Component
{
    use WithFileUploads;

    public Course $course;

    // Course Edit fields
    public $courseTitle;
    public $courseDescription;
    public $coursePrice;
    public $courseIsPublished;
    public $courseImage; // For uploading cover image

    // Section Management fields
    public $newSectionTitle = '';
    public $editingSectionId = null;
    public $editingSectionTitle = '';

    // Lesson Management fields
    public $selectedSectionId = null;
    public $newLessonTitle = '';
    
    // Lesson Form fields (for currently editing lesson modal)
    public $editingLessonId = null;
    public $lessonTitle = '';
    public $lessonContent = '';
    public $lessonVideoProvider = 'local';
    public $lessonVideoUrl = '';
    public $lessonIsFree = false;
    public $lessonVideoFile; // For uploading local video file
    public $lessonAttachmentFile; // For uploading downloadable files

    protected $rules = [
        'courseTitle' => 'required|string|max:255',
        'courseDescription' => 'nullable|string',
        'coursePrice' => 'required|numeric|min:0',
        'courseIsPublished' => 'boolean',
    ];

    // Listen for description updates from the hidden input
    public function updatedCourseDescription($value)
    {
        // Auto-save description to model on blur (triggered via form submit)
    }

    public function mount($course)
    {
        // Accept either id or Course model instance
        if (is_numeric($course)) {
            $this->course = Course::findOrFail($course);
        } else {
            $this->course = $course;
        }

        $this->courseTitle = $this->course->title;
        $this->courseDescription = $this->course->description;
        $this->coursePrice = $this->course->price;
        $this->courseIsPublished = $this->course->is_published;
    }

    public function updateCourse()
    {
        $this->validate();

        $this->course->update([
            'title' => $this->courseTitle,
            'description' => $this->courseDescription,
            'price' => $this->coursePrice,
            'is_published' => $this->courseIsPublished,
        ]);

        if ($this->courseImage) {
            $this->course->clearMediaCollection('cover');
            $this->course->addMedia($this->courseImage->getRealPath())
                ->usingFileName($this->courseImage->getClientOriginalName())
                ->toMediaCollection('cover');
        }

        session()->flash('course_message', 'Curso actualizado correctamente.');
    }

    // Section actions
    public function addSection()
    {
        $this->validate(['newSectionTitle' => 'required|string|max:255']);
        
        $order = $this->course->sections()->count();
        Section::create([
            'course_id' => $this->course->id,
            'title' => $this->newSectionTitle,
            'order' => $order,
        ]);

        $this->newSectionTitle = '';
        session()->flash('sections_message', 'Sección agregada con éxito.');
    }

    public function editSection($id)
    {
        $section = Section::findOrFail($id);
        $this->editingSectionId = $id;
        $this->editingSectionTitle = $section->title;
    }

    public function updateSection()
    {
        $this->validate(['editingSectionTitle' => 'required|string|max:255']);
        
        $section = Section::findOrFail($this->editingSectionId);
        $section->update(['title' => $this->editingSectionTitle]);

        $this->editingSectionId = null;
        $this->editingSectionTitle = '';
    }

    public function deleteSection($id)
    {
        Section::findOrFail($id)->delete();
        session()->flash('sections_message', 'Sección eliminada con éxito.');
    }

    public function moveSection($id, $direction)
    {
        $section = Section::findOrFail($id);
        $currentOrder = $section->order;

        if ($direction === 'up') {
            $swapSection = $this->course->sections()->where('order', '<', $currentOrder)->orderBy('order', 'desc')->first();
        } else {
            $swapSection = $this->course->sections()->where('order', '>', $currentOrder)->orderBy('order', 'asc')->first();
        }

        if ($swapSection) {
            $section->update(['order' => $swapSection->order]);
            $swapSection->update(['order' => $currentOrder]);
        }
    }

    // Lesson actions
    public function selectSectionForLesson($sectionId)
    {
        $this->selectedSectionId = $sectionId;
        $this->newLessonTitle = '';
    }

    public function addLesson()
    {
        $this->validate(['newLessonTitle' => 'required|string|max:255']);
        
        $section = Section::findOrFail($this->selectedSectionId);
        $order = $section->lessons()->count();

        Lesson::create([
            'section_id' => $this->selectedSectionId,
            'title' => $this->newLessonTitle,
            'slug' => '', // Automatically handled by spatie/laravel-sluggable
            'order' => $order,
            'video_provider' => 'local',
            'is_free' => false,
        ]);

        $this->newLessonTitle = '';
        $this->selectedSectionId = null;
        session()->flash('sections_message', 'Lección agregada con éxito.');
    }

    public function openEditLessonModal($lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);
        $this->editingLessonId = $lessonId;
        $this->lessonTitle = $lesson->title;
        $this->lessonContent = $lesson->content;
        $this->lessonVideoProvider = $lesson->video_provider;
        $this->lessonVideoUrl = $lesson->video_url;
        $this->lessonIsFree = $lesson->is_free;
        $this->lessonVideoFile = null;
        $this->lessonAttachmentFile = null;
    }

    public function updateLesson()
    {
        $this->validate([
            'lessonTitle' => 'required|string|max:255',
            'lessonContent' => 'nullable|string',
            'lessonVideoProvider' => 'required|in:local,drive,youtube',
            'lessonVideoUrl' => 'nullable|string',
            'lessonIsFree' => 'boolean',
        ]);

        $lesson = Lesson::findOrFail($this->editingLessonId);
        $lesson->update([
            'title' => $this->lessonTitle,
            'content' => $this->lessonContent,
            'video_provider' => $this->lessonVideoProvider,
            'video_url' => $this->lessonVideoUrl,
            'is_free' => $this->lessonIsFree,
        ]);

        if ($this->lessonVideoFile) {
            $lesson->clearMediaCollection('video');
            $lesson->addMedia($this->lessonVideoFile->getRealPath())
                ->usingFileName($this->lessonVideoFile->getClientOriginalName())
                ->toMediaCollection('video');
        }

        if ($this->lessonAttachmentFile) {
            $lesson->addMedia($this->lessonAttachmentFile->getRealPath())
                ->usingFileName($this->lessonAttachmentFile->getClientOriginalName())
                ->toMediaCollection('downloads');
        }

        $this->editingLessonId = null;
        session()->flash('sections_message', 'Lección actualizada con éxito.');
    }

    public function deleteLesson($id)
    {
        Lesson::findOrFail($id)->delete();
        session()->flash('sections_message', 'Lección eliminada con éxito.');
    }

    public function moveLesson($id, $direction)
    {
        $lesson = Lesson::findOrFail($id);
        $section = $lesson->section;
        $currentOrder = $lesson->order;

        if ($direction === 'up') {
            $swapLesson = $section->lessons()->where('order', '<', $currentOrder)->orderBy('order', 'desc')->first();
        } else {
            $swapLesson = $section->lessons()->where('order', '>', $currentOrder)->orderBy('order', 'asc')->first();
        }

        if ($swapLesson) {
            $swapOrder = $swapLesson->order;
            $lesson->update(['order' => $swapOrder]);
            $swapLesson->update(['order' => $currentOrder]);
        }
    }

    public function removeMedia($lessonId, $mediaId)
    {
        $lesson = Lesson::findOrFail($lessonId);
        $lesson->media()->findOrFail($mediaId)->delete();
    }

    public function render()
    {
        $sections = $this->course->sections()->with(['lessons' => function($q) {
            $q->orderBy('order');
        }, 'lessons.media'])->orderBy('order')->get();

        return view('livewire.admin.course-editor', compact('sections'))
            ->layout('layouts.admin');
    }
}
