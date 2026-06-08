<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Course;
use App\Models\Group;

class CourseManager extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $showCreateModal = false;

    // Form fields
    public $title = '';
    public $price = 0.00;
    public $description = '';
    public $is_published = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'description' => 'nullable|string',
        'is_published' => 'boolean',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetFields();
        $this->showCreateModal = true;
    }

    public function resetFields()
    {
        $this->title = '';
        $this->price = 0.00;
        $this->description = '';
        $this->is_published = false;
        $this->resetValidation();
    }

    public function store()
    {
        $this->validate();

        $course = Course::create([
            'title' => $this->title,
            'price' => $this->price,
            'description' => $this->description,
            'is_published' => $this->is_published,
        ]);

        // Automatically create a learning group for the course
        Group::create([
            'course_id' => $course->id,
            'name' => "Comunidad de " . $course->title,
            'description' => "Grupo de estudio y foro de preguntas y respuestas para el curso " . $course->title,
        ]);

        $this->showCreateModal = false;
        $this->resetFields();

        session()->flash('message', 'Curso creado con éxito.');
    }

    public function delete($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        session()->flash('message', 'Curso eliminado con éxito.');
    }

    public function render()
    {
        $courses = Course::where('title', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.course-manager', compact('courses'))
            ->layout('layouts.admin');
    }
}
