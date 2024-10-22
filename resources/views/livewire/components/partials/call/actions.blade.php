<div class="dropdown dropleft close-dropdown">
    <button type="button" class="btn close dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Close">
        <span aria-hidden="true"><span class="fa fa-ellipsis-h" aria-hidden="true"></span></span>
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#edit" wire:click="toggleEditMode()">Edit</a></li>
        <li><a class="dropdown-item" href="#delete" wire:click.prevent="delete()">Delete</a></li>
    </ul>
</div>
