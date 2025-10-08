<!-- removeNotificationModal -->
<div
    id="removeNotificationModal"
    class="modal fade zoomIn"
    tabindex="-1"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                    id="NotificationModalbtn-close"
                ></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon
                        src="https://cdn.lordicon.com/gsqxdxog.json"
                        trigger="loop"
                        colors="primary:#f7b84b,secondary:#f06548"
                        style="width:100px;height:100px"
                    ></lord-icon>
                    <div class="fs-15 mx-sm-5 mx-4 mt-4 pt-2">
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                    </div>
                </div>
                <div class="d-flex justify-content-center mb-2 mt-4 gap-2">
                    <button
                        type="button"
                        class="btn w-sm btn-light"
                        data-bs-dismiss="modal"
                    >Close</button>
                    <button
                        type="button"
                        class="btn w-sm btn-danger"
                        id="delete-notification"
                    >Yes, Delete It!</button>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
