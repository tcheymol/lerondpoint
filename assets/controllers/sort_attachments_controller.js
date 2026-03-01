import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['item', 'positions', 'container'];

    connect() {
        this.draggedItem = null;
        this.syncPositions();
    }

    dragstart(event) {
        this.draggedItem = event.currentTarget;
        setTimeout(() => event.currentTarget.classList.add('opacity-25'), 0);
        event.dataTransfer.effectAllowed = 'move';
    }

    dragend(event) {
        event.currentTarget.classList.remove('opacity-25');
        this.draggedItem = null;
        this.syncPositions();
    }

    dragover(event) {
        event.preventDefault();
        event.dataTransfer.dropEffect = 'move';

        if (!this.draggedItem || event.currentTarget === this.draggedItem) return;

        const container = this.containerTarget;
        const dragged = this.draggedItem;
        const target = event.currentTarget;

        const children = [...container.children];
        const draggedIndex = children.indexOf(dragged);
        const targetIndex = children.indexOf(target);

        if (draggedIndex < targetIndex) {
            container.insertBefore(dragged, target.nextSibling);
        } else {
            container.insertBefore(dragged, target);
        }
    }

    drop(event) {
        event.preventDefault();
    }

    syncPositions() {
        const ids = this.itemTargets.map(item => item.dataset.attachmentId);
        this.positionsTarget.value = ids.join(',');
    }
}
