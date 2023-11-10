<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Create Role</h6>
                </div>
                <div class="modal-body">
                    <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Role *</label>
                                <input type="text" class="form-control" id="roleName">
                            </div>
                            @php
                                $permissions =  \App\Models\Permission::all();
                            @endphp
                            @foreach ($permissions as $key => $permission)
                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                    <div class="p-2 border mt-1 mb-2">
                                        <label class="control-label">{{ Str::headline($permission->name) }}</label>
                                        <input type="checkbox" class="permissions" name="permissions[]" value="{{ $permission->id }}">
                                    </div>
                                </div>
                            @endforeach

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

        let roleName = document.getElementById('roleName').value;
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        var checkedValues = [];
        checkboxes.forEach(function (checkbox) {
            if (checkbox.checked) {
                checkedValues.push(checkbox.value);
            }
        });
            //console.log('Checked Values:', checkedValues);

        if (roleName.length === 0) {
            errorToast("Role Name Required !")
        }else if(checkedValues.length === 0){
            errorToast("Min 1 Permission Required !")
        }
        else {

            document.getElementById('modal-close').click();

            showLoader();
            try{
                let res = await axios.post("/create-role",{name:roleName,permissions:checkedValues})
                hideLoader();

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
                errorToast(e);
                console.log(e)
            }

        }
    }

</script>
