<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Create Post</h6>
                </div>
                <div class="modal-body">
                    <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label" for="PostTitle">Title *</label>
                                <input type="text" class="form-control" id="PostTitle">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label" for="PostDescription">Description *</label>
                                <textarea type="text" class="form-control" id="PostDescription"></textarea>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="modal-close" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button onclick="Save()" id="save-btn" class="btn btn-sm  btn-success" >Save</button>
                </div>
            </div>
    </div>
</div>


<script>

    async function Save() {

        let PostTitle = document.getElementById('PostTitle').value;

        let PostDescription = document.getElementById('PostDescription').value;

       if (PostTitle.length === 0) {
            errorToast("Title Required !")
        }else if (PostDescription.length === 0) {
            errorToast("Description Required !")
        }
        else {

            document.getElementById('modal-close').click();

            showLoader();
            try {
                let res = await axios.post("/create-post",{title:PostTitle,description:PostDescription})
                hideLoader();
                //console.log(res);
                if(res.status===201){
                    successToast('Request completed');
                    document.getElementById("save-form").reset();
                    await getList();
                }
                else{
                    errorToast("Request fail !")
                }
            }catch (e) {
                hideLoader();
                //errorToast(e);
                errorToast('You are not Permited for Create Post');
                document.getElementById("save-form").reset();
                await getList();
            }

        }
    }

</script>
