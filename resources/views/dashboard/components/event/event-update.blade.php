<div class="modal" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Income</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-6 p-1">
                                <label class="form-label">Date *</label>
                                <input type="date" class="form-control" id="eventUpdateDate">
                            </div>
                            <div class="col-6 p-1">
                                <label class="form-label">Time *</label>
                                <input type="time" class="form-control" id="eventUpdateTime">
                            </div>
                            <div class="col-6 p-1">
                                <label class="form-label">Category *</label>
                                <select name="type" id="eventUpdateCategory" class="form-control">
                                    <option value="">--select--</option>
                                    {{-- @forelse ($categories as $categorie)
                                        <option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
                                    @empty
                                        <option value="Income">No Category Found!</option>
                                    @endforelse --}}
                                    
                                </select>
                            </div>
                            <div class="col-6 p-1">
                                <label class="form-label">Type *</label>
                                <select name="type" id="eventUpdateType" class="form-control">
                                    <option value="">--select--</option>
                                    <option value="Feature">Feature</option>
                                    <option value="Recent">Recent</option>
                                </select>
                            </div>
                            <div class="col-6 p-1">
                                <label class="form-label">Title *</label>
                                <input type="text" class="form-control" id="eventUpdateTitle" placeholder="Title">
                            </div>
                            <div class="col-6 p-1">
                                <label class="form-label">Location *</label>
                                <input type="text" class="form-control" id="eventUpdateLocation" placeholder="Location">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Description </label>
                                <textarea type="text" class="form-control" id="eventUpdateDescription" placeholder="Description"></textarea>
                                <input class="d-none" id="updateID">
                                <input class="d-none" id="eventUpdateOldImage">
                            </div>
                            
                            
                            <div class="col-12 p-1">
                                <br/>
                                <img class="w-15" id="newUpdateImg" src="{{asset('backend/images/default.jpg')}}"/>
                                <br/>

                                <label class="form-label">Thumbnail *</label>
                                <input oninput="newUpdateImg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="eventUpdateImage" onchange="validateUpdateFileType()" accept="image/png, image/jpeg, image/jpg">
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
FillCategoryDropDown();

async function FillCategoryDropDown(){
    let res = await axios.get("/list-category")
    res.data.forEach(function (item,i) {
        let option=`<option value="${item['id']}">${item['name']}</option>`
        $("#eventUpdateCategory").append(option);
    })
}

   async function FillUpUpdateForm(id){
        document.getElementById('updateID').value=id;
        showLoader();
        let res=await axios.post("/event-by-id",{id:id})
        hideLoader();
        document.getElementById('eventUpdateDate').value =res.data['date'];
        document.getElementById('eventUpdateTime').value = res.data['time']
        document.getElementById('eventUpdateType').value = res.data['type']
        document.getElementById('eventUpdateCategory').value =res.data['categorie_id'];
        document.getElementById('eventUpdateTitle').value = res.data['title']
        document.getElementById('eventUpdateLocation').value = res.data['location']
        document.getElementById('eventUpdateDescription').value = res.data['description'];
        document.getElementById('eventUpdateOldImage').value = res.data['image'];
    }

    async function Update() {

        let eventUpdateDate = document.getElementById('eventUpdateDate').value;
        let eventUpdateTime = document.getElementById('eventUpdateTime').value;
        let eventUpdateType = document.getElementById('eventUpdateType').value;
        let eventUpdateCategory = document.getElementById('eventUpdateCategory').value;
        let eventUpdateTitle = document.getElementById('eventUpdateTitle').value;
        let eventUpdateLocation = document.getElementById('eventUpdateLocation').value;
        let eventUpdateDescription = document.getElementById('eventUpdateDescription').value;
        let eventUpdateImage = document.getElementById('eventUpdateImage').files[0];
        let eventUpdateOldImage = document.getElementById('eventUpdateOldImage').value;
        let updateID=document.getElementById('updateID').value;
        //alert(isNaN(parseFloat(eventTitle)))
        if (eventUpdateDate.length === 0) {
            errorToast("Date Required !")
        } else if (eventUpdateTime.length === 0) {
            errorToast("Time Required !")
        }else if (eventUpdateType.length === 0) {
            errorToast("Event Type Required !")
        }else if (eventUpdateCategory.length === 0) {
            errorToast("Event Category Required !")
        }else if (eventUpdateTitle.length === 0 ) {
            errorToast("Event Title Required !")
        }else if (eventUpdateLocation.length === 0 ) {
            errorToast("Event Location Required !")
        }else if (eventUpdateDescription.length === 0 ){
            errorToast("Event Description Required !")
        }
        else {
            document.getElementById('update-modal-close').click();
            let formData=new FormData();
            formData.append('id',updateID)
            formData.append('image',eventUpdateImage)
            formData.append('oldImage',eventUpdateOldImage)
            formData.append('type',eventUpdateType)
            formData.append('title',eventUpdateTitle)
            formData.append('description',eventUpdateDescription)
            formData.append('date',eventUpdateDate)
            formData.append('time',eventUpdateTime)
            formData.append('location',eventUpdateLocation)
            formData.append('categorie_id',eventUpdateCategory)

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }
            showLoader();
            let res = await axios.post("/update-event",formData,config)
            hideLoader();

            if(res.status===200 && res.data===1){
                document.getElementById("update-form").reset();
                successToast("Request success !")
                await getList();
            }
            else{
                errorToast("Request fail !")
            }


        }



    }
    function validateUpdateFileType(){
        var fileName = document.getElementById("eventUpdateImage").value;
            var idxDot = fileName.lastIndexOf(".") + 1;
            var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
            var allowedExt = ['jpg','jpeg','png'];
            if (allowedExt.indexOf(extFile) != -1 ){
                //successToast('File attachment completed');
            }else{
                errorToast('Only JPG,JPEG,PNG files are allowed');
                document.getElementById("eventUpdateImage").value='';
                return;
              }   
        }


</script>
