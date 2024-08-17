<div wire:ignore>
    <canvas id="whiteboard" width="800" height="600" style="border:1px solid #000;"></canvas>
</div>

<script src="https://unpkg.com/fabric@5.3.1/dist/fabric.min.js"></script>

<script>
    document.addEventListener('livewire:load', function () {
        const canvas = new fabric.Canvas('whiteboard');
        canvas.isDrawingMode = true; // Enable drawing mode
        canvas.freeDrawingBrush.color = 'black'; // Set default brush color
        canvas.freeDrawingBrush.width = 5; // Set default brush width

        // Load canvas data from Livewire
        @this.on('refreshCanvas', canvasData => {
            canvas.loadFromJSON(canvasData, canvas.renderAll.bind(canvas));
        });

        // Handle mouse down event to start drawing
        canvas.on('mouse:down', function () {
            if (@this.activeUser && @this.activeUser !== {{ Auth::id() }}) {
                return;
            }
            canvas.isDrawingMode = true; // Ensure drawing mode is enabled
            @this.setDrawingUser(); // Notify Livewire of the drawing user
        });

        // Handle mouse up event to stop drawing
        canvas.on('mouse:up', function () {
            canvas.isDrawingMode = false; // Disable drawing mode
            @this.canvasData = JSON.stringify(canvas.toJSON()); // Serialize canvas data
            @this.broadcastCanvasUpdate(); // Broadcast canvas update
        });

        // Handle object added event to update canvas data
        canvas.on('object:added', function () {
            if (canvas.isDrawingMode) {
                @this.canvasData = JSON.stringify(canvas.toJSON()); // Update canvas data
                @this.broadcastCanvasUpdate(); // Broadcast canvas update
            }
        });

        // Handle object modified event
        canvas.on('object:modified', function () {
            if (canvas.isDrawingMode) {
                @this.canvasData = JSON.stringify(canvas.toJSON()); // Update canvas data
                @this.broadcastCanvasUpdate(); // Broadcast canvas update
            }
        });

        // Handle object removed event
        canvas.on('object:removed', function () {
            if (canvas.isDrawingMode) {
                @this.canvasData = JSON.stringify(canvas.toJSON()); // Update canvas data
                @this.broadcastCanvasUpdate(); // Broadcast canvas update
            }
        });

        // Optional: Handle mouse move event for additional logic
        canvas.on('mouse:move', function () {
            // Implement any additional logic if needed
        });
    });
</script>
