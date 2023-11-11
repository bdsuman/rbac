<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Create User </h6>
                </div>
                <div class="modal-body">
                    <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <div class="row m-0 p-0">
                                    <div class="col-md-6 p-2">
                                        <label>Email Address</label>
                                        <input id="email" placeholder="User Email" class="form-control" type="email"/>
                                    </div>
                                    <div class="col-md-6 p-2">
                                        <label>First Name</label>
                                        <input id="name" placeholder="First Name" class="form-control" type="text"/>
                                    </div>
                                    <div class="col-md-12 p-2">
                                        <label for="role">Role</label>

                                        <select class="form-control" id="role">
                                            <option value="">--select--</option>

                                        </select>

                                    </div>
                                    <div class="col-md-6 p-2">
                                        <label for="mobile">Mobile Number</label>
                                        <input id="mobile" placeholder="Mobile" class="form-control" type="text"/>
                                    </div>
                                    <div class="col-md-6 p-2">
                                        <label for="password">Password</label>
                                        <input id="password" placeholder="User Password" class="form-control" type="password"/>
                                    </div>
                                </div>
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
    async function FillRoleDropDown(){
        let res = await axios.get("/list-role")
        res.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['name']}</option>`
            $("#role").append(option);
        })
    }

   FillRoleDropDown();
    async function Save() {

        let email = document.getElementById('email').value;
        let name = document.getElementById('name').value;
        let role = document.getElementById('role').value;
        let mobile = document.getElementById('mobile').value;
        let password = document.getElementById('password').value;

        if(email.length===0){
            errorToast('Email is required')
        }
        else if(name.length===0){
            errorToast('First Name is required')
        }
        else if(role.length===0){
            errorToast('Role is required')
        }
        else if(mobile.length===0){
            errorToast('Mobile is required')
        }
        else if(password.length===0){
            errorToast('Password is required')
        }
        else{
            document.getElementById('modal-close').click();
            showLoader();
            let res=await axios.post("/user-registration",{
                email:email,
                name:name,
                role:role,
                mobile:mobile,
                password:password
            })
            hideLoader();
            if(res.status===200 && res.data['status']==='success'){
                successToast(res.data['message']);
                document.getElementById("save-form").reset();
                await getList();
            }
            else{
                errorToast(res.data['message'])
            }
        }
    }

</script>
