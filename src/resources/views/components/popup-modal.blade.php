<div class="popup-overlay fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center w-full h-full">
    <div class="bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-xl mb-2">Are you certain you want to delete this warehouse?</h2>
        <p><b>Please note: </b>Deleting this warehouse will result in the removal of all associated products.</p>
        <button class="confirm-btn" onclick="actionDeleteWarehouse()">Delete</button>
        <button class="cancel-btn" onclick="closePopup()">Cancel</button>
    </div>

    <script>
        $(".popup-overlay").hide();

        function closePopup() {
            $(".popup-overlay").toggle();
        }

        function actionDeleteWarehouse() {
            document.getElementById("deleteForm").submit();
        }
    </script>
</div>
