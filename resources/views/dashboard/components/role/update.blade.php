<div class="modal" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Role</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Name *</label>
                                <input type="text" class="form-control" id="roleNameUpdate">
                                <input class="d-none" id="updateID">
                            </div>
                            <div style="display: flex;" class="row" id="updatePermission">
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
    async function UpdateFillPermissionList(id){
        let res = await axios.post("/list-permission-assign",{id:id})
        res.data.forEach(function (item,i) {

            let option = `<div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                    <div class="p-2 border mt-1 mb-2">
                                        <label class="control-label">${item['name']}</label>
                                        <input type="checkbox" class="permissions" ${item['checked']} name="permissions[]" value="${item['id']}">
                                    </div>
                            </div>`;
            $("#updatePermission").append(option);
        })
    }

   async function FillUpUpdateForm(id){
        document.getElementById('updateID').value=id;
        showLoader();
       $ ("#updatePermission").html ("");
       await UpdateFillPermissionList(id);
        let res=await axios.post("/role-by-id",{id:id})
        hideLoader();
        document.getElementById('roleNameUpdate').value=res.data['name'];
    }

    async function Update() {

        let roleNameUpdate = document.getElementById('roleNameUpdate').value;
        let updateID = document.getElementById('updateID').value;
        let checkboxes = document.querySelectorAll('input[type="checkbox"]');
        let checkedValues = [];
        checkboxes.forEach(function (checkbox) {
            if (checkbox.checked) {
                checkedValues.push(checkbox.value);
            }
        });
        console.log(checkedValues);
        if (roleNameUpdate.length === 0) {
            errorToast("Role Name Required !")
        }else if(checkedValues.length === 0){
            errorToast("Min 1 Permission Required !")
        }
        else{

            document.getElementById('update-modal-close').click();
            showLoader();
            try {
                let res = await axios.post("/update-role",{name:roleNameUpdate,permissions:checkedValues,id:updateID})
                hideLoader();
                //console.log( res);
                if(res.status===200){
                    document.getElementById("update-form").reset();
                    successToast("Request success !")
                    await getList();
                }
                else{
                    errorToast("Request fail !")
                }
            }catch (e) {
                errorToast(e)
                hideLoader();
                await getList();
            }



        }



    }



</script>
