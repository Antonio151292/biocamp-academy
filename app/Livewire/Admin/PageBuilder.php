<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Page;

class PageBuilder extends Component
{
    use WithFileUploads;

    public $page;
    public $sections = [];

    // Temporary upload fields
    public $uploadedImage;
    public $uploadedVideo;

    // Selected section for editing
    public $selectedSectionId = null;
    public $selectedSectionType = null;
    public $selectedSectionData = [];

    // Available types
    public $availableTypes = [
        'hero' => 'Banner Principal (Hero)',
        'features' => 'Beneficios / Características',
        'courses' => 'Cursos Destacados',
        'cta' => 'Llamada a la Acción (CTA)',
        'faq' => 'Preguntas Frecuentes (FAQ)',
        'rich_text' => 'Bloque de Texto / Título (TinyMCE y Fuentes)',
        'image_block' => 'Bloque de Imagen (Diseño Canva)',
        'video_block' => 'Bloque de Video (Incrustar o Local)',
    ];

    public function mount()
    {
        $this->page = Page::firstOrCreate(
            ['name' => 'home'],
            [
                'title' => 'Página de Inicio',
                'content' => [
                    [
                        'id' => 'hero_default',
                        'type' => 'hero',
                        'title' => 'Biocamp Academy',
                        'subtitle' => 'Plataforma de cursos interactiva con soporte híbrido y chat en tiempo real.',
                        'button_text' => 'Ver Cursos',
                        'button_url' => '/catalog',
                        'bg_gradient' => 'from-violet-900 to-indigo-900',
                    ]
                ]
            ]
        );

        $this->sections = $this->page->content ?? [];
    }

    public function addSection($type)
    {
        $newId = $type . '_' . uniqid();
        $newSection = [
            'id' => $newId,
            'type' => $type,
        ];

        // Default values based on type
        if ($type === 'hero') {
            $newSection['title'] = 'Nuevo Banner';
            $newSection['subtitle'] = 'Descripción de tu banner principal';
            $newSection['button_text'] = 'Comenzar';
            $newSection['button_url'] = '/catalog';
            $newSection['bg_gradient'] = 'from-violet-950 via-slate-900 to-indigo-950';
            $newSection['bg_image_url'] = '';
            $newSection['title_font'] = 'Outfit';
            $newSection['title_size'] = 'text-5xl';
            $newSection['title_color'] = '#ffffff';
        } elseif ($type === 'features') {
            $newSection['title'] = 'Nuestros Beneficios';
            $newSection['items'] = [
                ['icon' => 'fas fa-star', 'title' => 'Calidad', 'desc' => 'Descripción de calidad'],
                ['icon' => 'fas fa-laptop', 'title' => 'Flexibilidad', 'desc' => 'Estudia a tu ritmo'],
            ];
        } elseif ($type === 'courses') {
            $newSection['title'] = 'Cursos Destacados';
            $newSection['subtitle'] = 'Explora nuestros programas académicos populares';
            $newSection['limit'] = 6;
        } elseif ($type === 'cta') {
            $newSection['title'] = '¿Listo para comenzar a aprender?';
            $newSection['subtitle'] = 'Regístrate hoy y accede a contenido exclusivo.';
            $newSection['button_text'] = 'Crear Cuenta Gratis';
            $newSection['button_url'] = '/register';
            $newSection['bg_image_url'] = '';
            $newSection['title_font'] = 'Outfit';
        } elseif ($type === 'faq') {
            $newSection['title'] = 'Preguntas Frecuentes';
            $newSection['items'] = [
                ['question' => '¿Cómo funciona la suscripción?', 'answer' => 'Tienes acceso completo a todos los cursos.'],
                ['question' => '¿Los cursos son permanentes?', 'answer' => 'Sí, si compras un curso individual.'],
            ];
        } elseif ($type === 'rich_text') {
            $newSection['title'] = 'Bloque de Texto';
            $newSection['content'] = '<p>Comienza a escribir tu texto visual con tipografías personalizadas...</p>';
            $newSection['font_family'] = 'Inter';
            $newSection['title_font'] = 'Outfit';
            $newSection['title_color'] = '#ffffff';
            $newSection['text_color'] = '#cbd5e1';
            $newSection['alignment'] = 'center';
        } elseif ($type === 'image_block') {
            $newSection['title'] = 'Leyenda de la imagen';
            $newSection['image_url'] = '';
            $newSection['width'] = 80;
            $newSection['alignment'] = 'center';
            $newSection['style'] = 'shadow';
        } elseif ($type === 'video_block') {
            $newSection['video_url'] = '';
            $newSection['width'] = 80;
            $newSection['alignment'] = 'center';
        }

        $this->sections[] = $newSection;
        $this->savePage();
    }

    public function deleteSection($id)
    {
        $this->sections = array_values(array_filter($this->sections, function ($sec) use ($id) {
            return $sec['id'] !== $id;
        }));

        if ($this->selectedSectionId === $id) {
            $this->selectedSectionId = null;
        }

        $this->savePage();
    }

    public function selectSection($id)
    {
        $this->selectedSectionId = $id;
        foreach ($this->sections as $sec) {
            if ($sec['id'] === $id) {
                $this->selectedSectionType = $sec['type'];
                $this->selectedSectionData = $sec;
                break;
            }
        }
    }

    public function updateSelectedSection()
    {
        foreach ($this->sections as &$sec) {
            if ($sec['id'] === $this->selectedSectionId) {
                $sec = $this->selectedSectionData;
                break;
            }
        }

        $this->savePage();
        session()->flash('builder_message', 'Sección de página actualizada.');
    }

    public function moveSection($index, $direction)
    {
        $targetIndex = $direction === 'up' ? $index - 1 : $index + 1;

        if ($targetIndex >= 0 && $targetIndex < count($this->sections)) {
            $temp = $this->sections[$index];
            $this->sections[$index] = $this->sections[$targetIndex];
            $this->sections[$targetIndex] = $temp;
            $this->savePage();
        }
    }

    // Helper functions for array bindings in livewire
    public function addFeatureItem()
    {
        $this->selectedSectionData['items'][] = ['icon' => 'fas fa-circle', 'title' => 'Nuevo Item', 'desc' => 'Detalle del item'];
    }

    public function removeFeatureItem($index)
    {
        unset($this->selectedSectionData['items'][$index]);
        $this->selectedSectionData['items'] = array_values($this->selectedSectionData['items']);
    }

    public function addFaqItem()
    {
        $this->selectedSectionData['items'][] = ['question' => 'Nueva Pregunta', 'answer' => 'Respuesta a la pregunta'];
    }

    public function removeFaqItem($index)
    {
        unset($this->selectedSectionData['items'][$index]);
        $this->selectedSectionData['items'] = array_values($this->selectedSectionData['items']);
    }

    public function updatedUploadedImage()
    {
        $this->validate([
            'uploadedImage' => 'required|image|max:5120', // 5MB max
        ]);

        $path = $this->uploadedImage->store('page-builder', 'public');
        $url = asset('storage/' . $path);

        if ($this->selectedSectionType === 'hero' || $this->selectedSectionType === 'cta') {
            $this->selectedSectionData['bg_image_url'] = $url;
        } elseif ($this->selectedSectionType === 'image_block') {
            $this->selectedSectionData['image_url'] = $url;
        }

        $this->updateSelectedSection();
        $this->uploadedImage = null; // Clear file input helper
        session()->flash('builder_message', 'Imagen cargada y aplicada.');
    }

    public function updatedUploadedVideo()
    {
        $this->validate([
            'uploadedVideo' => 'required|mimetypes:video/mp4,video/quicktime,video/webm|max:20480', // 20MB max
        ]);

        $path = $this->uploadedVideo->store('page-builder', 'public');
        $url = asset('storage/' . $path);

        if ($this->selectedSectionType === 'video_block') {
            $this->selectedSectionData['video_url'] = $url;
        }

        $this->updateSelectedSection();
        $this->uploadedVideo = null; // Clear file input helper
        session()->flash('builder_message', 'Video cargado y aplicado.');
    }

    public function updateSectionsOrder($orderIds)
    {
        $newSections = [];
        foreach ($orderIds as $id) {
            foreach ($this->sections as $sec) {
                if ($sec['id'] === $id) {
                    $newSections[] = $sec;
                    break;
                }
            }
        }
        $this->sections = $newSections;
        $this->savePage();
        
        if ($this->selectedSectionId) {
            $this->selectSection($this->selectedSectionId);
        }
        
        session()->flash('builder_message', 'Orden de secciones actualizado.');
    }

    public function savePage()
    {
        $this->page->update([
            'content' => $this->sections
        ]);
    }

    public function render()
    {
        return view('livewire.admin.page-builder')
            ->layout('layouts.admin');
    }
}
