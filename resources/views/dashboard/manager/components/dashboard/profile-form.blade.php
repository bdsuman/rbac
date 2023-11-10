<div class="container">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <h4>User Profile</h4>
                    <hr/>
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <label>Email Address</label>
                                <input readonly id="email" placeholder="User Email" class="form-control" type="email"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>First Name</label>
                                <input id="name" placeholder="First Name" class="form-control" type="text"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Mobile Number</label>
                                <input id="mobile" placeholder="Mobile" class="form-control" type="mobile"/>
                            </div>
                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <button onclick="onUpdate()" class="btn mt-3 w-100  btn-primary">Update</button>
                            </div>
                        </div>
                        <hr style="border-bottom: solid 5px black; ">
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <label>Previous Password</label>
                                <input id="old_password" placeholder="Previous Password" class="form-control" type="password"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>New Password</label>
                                <input id="new_password" placeholder="New Password" class="form-control" type="password"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Confirm Password</label>
                                <input id="confirm_password" placeholder="Confirm Password" class="form-control" type="password"/>
                            </div>
                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <button onclick="onUpdatePassword()" class="btn mt-3 w-100  btn-primary">Update Password</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    getProfile();
    async function getProfile(){
        showLoader();
        let res=await axios.get("/manager/user-profile")
        hideLoader();
        if(res.status===200 && res.data['status']==='success'){
            let data=res.data['data'];
            document.getElementById('email').value=data['email'];
            document.getElementById('name').value=data['name'];
            document.getElementById('mobile').value=data['mobile'];
        }
        else{
            errorToast(res.data['message'])
        }

    }

    async function onUpdate() {


        let name = document.getElementById('name').value;
        let mobile = document.getElementById('mobile').value;
        if(name.length===0){
            errorToast('Name is required')
        }
        else if(mobile.length===0){
            errorToast('Mobile is required')
        }
        else{
            showLoader();
            let res=await axios.post("/manager/user-update",{
                name:name,
                mobile:mobile,
            })
            hideLoader();
            if(res.status===200 && res.data['status']==='success'){
                successToast(res.data['message']);
                await getProfile();
            }
            else{
                errorToast(res.data['message'])
            }
        }
    }
    async function onUpdatePassword() {


        let old_password = document.getElementById('old_password').value;
        let new_password = document.getElementById('new_password').value;
        let confirm_password = document.getElementById('confirm_password').value;
        console.log(old_password,new_password,confirm_password);
        if(old_password.length===0){
            errorToast('Old Password is required')
        }
        else if(new_password.length===0){
            errorToast('New Password is required')
        }
        else if(confirm_password.length===0){
            errorToast('Confirm Password is required')
        }
        else if(new_password.toString()!==confirm_password.toString()){
            errorToast('Confirm Password and New Password is Mismatch')
        }
        else{
            showLoader();
            let res=await axios.post("/manager/user-pass-update",{
                old_password:old_password,
                new_password:new_password
            })
            hideLoader();
            if(res.status===200 && res.data['status']==='success'){
                successToast(res.data['message']);
            }
            else{
                errorToast(res.data['message'])
            }
        }
    }

</script>

