<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        if ($request->hasFile('image')) {
            $data['image'] = 'storage/'.$request->file('image')->store('events', 'public');
        }
        Event::query()->create($data);

        return redirect()->route('dashboard')->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $data = $this->validatedData($request);
        if ($request->hasFile('image')) {
            $this->deleteUploadedImage($event->image);
            $data['image'] = 'storage/'.$request->file('image')->store('events', 'public');
        } elseif ($request->boolean('remove_image')) {
            $this->deleteUploadedImage($event->image);
            $data['image'] = null;
        }
        $event->update($data);

        return redirect()->route('dashboard')->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        $this->deleteUploadedImage($event->image);
        $event->delete();

        return redirect()->route('dashboard')->with('success', 'Agenda berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'start_date' => ['required', 'date'],
            'description' => ['required', 'string', 'max:5000'],
            'status' => ['required', 'string', 'max:50'],
            'status_tone' => ['required', Rule::in(['amber', 'sky', 'slate'])],
            'detail' => ['nullable', 'string', 'max:5000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'remove_image' => ['sometimes', 'boolean'],
        ]);

        unset($data['remove_image']);

        return $data;
    }

    private function deleteUploadedImage(?string $image): void
    {
        if ($image && str_starts_with($image, 'storage/events/')) {
            Storage::disk('public')->delete(substr($image, strlen('storage/')));
        }
    }
}
