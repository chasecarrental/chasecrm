<div class="dropdown dropleft close-dropdown">
    <button type="button" class="btn close dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Close">
        <span aria-hidden="true"><span class="fa fa-ellipsis-h" aria-hidden="true"></span></span>
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#edit" wire:click="toggleEditMode()">Edit</a></li>
        @if($note->pinned == 1)
            <li><a class="dropdown-item" href="#pin" wire:click.prevent="unpin()">Unpin this note</a></li>
        @else
            <li><a class="dropdown-item" href="#pin" wire:click.prevent="pin()">Pin this note</a></li>
        @endif
        <li><a class="dropdown-item" href="#delete" wire:click.prevent="delete()">Delete</a></li>
    </ul>
</div>
