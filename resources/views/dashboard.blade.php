<x-app-layout>
    <div class="header">
        <p><b>“🌟 Welcome to Your Idea Sanctuary! 🧠✨ Capture. Organize. Create.”</b></p>
    </div>

    <div class="create_note">
        <i class="far fa-plus"></i>
    </div>

    <x-note.create-modal />

    <div class="row">
        <x-note.note-card :notes="$notes" />
    </div>
</x-app-layout>