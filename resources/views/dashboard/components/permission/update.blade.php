<div class="modal" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Permission</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label for="roleUpdate">Role *</label>
                                <select class="form-control form-select" id="roleUpdate">
                                    <option value="" >--select role--</option>

                                </select>
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

    async function UpdateFillRoleDropDown(){
        let res = await axios.get("/list-role")
        res.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['name']}</option>`
            $("#roleUpdate").append(option);
        })
    }

    UpdateFillRoleDropDown();
   async function FillUpUpdateForm(id){
        document.getElementById('updateID').value=id;
        showLoader();
        let res = await axios.post("/permission-by-id",{id:id})
        //console.log(res);
        hideLoader();
        document.getElementById('roleUpdate').value=res.data[0];
    }

    async function Update() {

        let roleUpdate = document.getElementById('roleUpdate').value;
        let updateID = document.getElementById('updateID').value;

        if (roleUpdate.length === 0) {
            errorToast("Role Name Required !")
        }
        else{
            document.getElementById('update-modal-close').click();
            showLoader();
            let res = await axios.post("/update-permission",{role:roleUpdate,id:updateID})
            hideLoader();

            if(res.status===200){
                document.getElementById("update-form").reset();
                successToast("Request success !")
                await getList();
            }
            else{
                errorToast("Request fail !")
            }


        }



    }



</script>
