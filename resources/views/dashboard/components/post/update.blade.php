<div class="modal" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Post</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label" for="PostTitleUpdate">Title *</label>
                                <input type="text" class="form-control" id="PostTitleUpdate">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label" for="PostDescriptionUpdate">Description *</label>
                                <textarea type="text" class="form-control" id="PostDescriptionUpdate"></textarea>
                                <input class="d-none" id="updateID">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="update-modal-close" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Update()" id="update-btn" class="btn btn-sm  btn-success" >Update</button>
            </div>
        </div>
    </div>
</div>


<script>


   async function FillUpUpdateForm(id){
        document.getElementById('updateID').value=id;
        showLoader();
       try {
        let res=await axios.post("/post-by-id",{id:id})
        hideLoader();
        document.getElementById('PostTitleUpdate').value=res.data['title'];
        document.getElementById('PostDescriptionUpdate').value=res.data['description'];
       }catch (e) {
           hideLoader();
           //errorToast(e);
           errorToast('You are not Permited for Update Post');
           document.getElementById('update-modal-close').close();
       }
    }

    async function Update() {

        let PostTitleUpdate = document.getElementById('PostTitleUpdate').value;
        let PostDescriptionUpdate = document.getElementById('PostDescriptionUpdate').value;
        let updateID = document.getElementById('updateID').value;

        if (PostTitleUpdate.length === 0) {
            errorToast("Title Required !")
        }else if (PostDescriptionUpdate.length === 0) {
            errorToast("Descriptiom Required !")
        }
        else{
            document.getElementById('update-modal-close').click();
            showLoader();
            try {
            let res = await axios.post("/update-post",{title:PostTitleUpdate,description:PostDescriptionUpdate,id:updateID})
            hideLoader();

            if(res.status===200 && res.data===1){
                document.getElementById("update-form").reset();
                successToast("Request success !")
                await getList();
            }
            else{
                errorToast("Request fail !")
            }
            }catch (e) {
                hideLoader();
                //errorToast(e);
                errorToast('You are not Permited for Update Post');
                document.getElementById("save-form").reset();
                await getList();
            }


        }



    }



</script>
