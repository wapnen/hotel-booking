<template>
<div class="wrapper">
<sidebar title = "Hotels"></sidebar>
  <div class="main-panel">
    <!-- Navbar -->
    <navigation title = "Hotels"></navigation>
    <!-- End Navbar -->
    <div class="content">
      <div class="row">
        <div class="col-md-4">
          <div class="card card-user">
            <div class="card-body">
              <p class="card-text">
                <div class="author">
                  <div class="block block-one"></div>
                  <div class="block block-two"></div>
                  <div class="block block-three"></div>
                  <div class="block block-four"></div>
                      <img class="avatar"  v-bind:src="'/uploads/' + this.hotel.image">
                      <avatar-cropper
                          @uploading="handleUploading"
                          @uploaded="handleUploaded"
                          @completed="handleCompleted"
                          @error="handlerError"
                          trigger=".pick-avatar"
                          v-bind:upload-url="this.upload_url"
                          :labels="this.labels" />
                    <h5 class="title">{{this.hotel.name}}</h5>

                  <p class="description">
                    {{this.hotel.city}} , {{this.hotel.country}}
                  </p>
                </div>
              </p>

            </div>
            <div class="card-footer">
              <div class="button-container">
                  <button class="btn btn-primary btn-sm pick-avatar"  @click="uploadImg('/api/hotels/image', hotel.id)">Select an new image</button>
              </div>
            </div>
          </div>
        </div>
        <!-- edit hotel form -->
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              <h5 class="title">Edit Hotel</h5>
            </div>
            <div class="card-body">
              <form>
                  <input type="hidden" name="id" id="id" v-model="hotel.id">
                <div class="row">
                  <div class="col-md-5 pr-md-1">
                    <div class="form-group">
                      <label>Hotel name</label>
                      <input type="text" class="form-control"  placeholder="Hotel name" v-model = "hotel.name" required>
                    </div>
                  </div>
                  <div class="col-md-3 px-md-1">
                    <div class="form-group">
                      <label>Hotel phone</label>
                      <input type="text" class="form-control" id="phone" name="phone" placeholder="08023213223" v-model="hotel.phone" required>
                    </div>
                  </div>
                  <div class="col-md-4 pl-md-1">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Email address</label>
                      <input type="email" class="form-control" placeholder="hotel@email.com" id="email" name="email" v-model="hotel.email" required>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Address</label>
                      <input type="text" class="form-control" placeholder="Hotel Address" id="address" name="address" v-model = "hotel.address" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4 pr-md-1">
                    <div class="form-group">
                      <label>City</label>
                      <input type="text" class="form-control" placeholder="City" id="city" name="city" v-model = "hotel.city">
                    </div>
                  </div>
                  <div class="col-md-4 px-md-1">
                    <div class="form-group">
                      <label>Country</label>
                      <input type="text" class="form-control" placeholder="Country" v-model="hotel.country" id="country" name="country">
                    </div>
                  </div>
                  <div class="col-md-4 pl-md-1">
                    <div class="form-group">
                      <label>Postal Code</label>
                      <input type="text" class="form-control" placeholder="ZIP Code" id="zip" name="zip" v-model="hotel.zip_code">
                    </div>
                  </div>
                </div>

              </form>
            </div>
            <div class="card-footer">
              <button type="submit" @click="updateHotel()" class="btn btn-fill btn-primary ">Save</button>
            </div>
          </div>
        </div>
        <!-- end edit hotel form -->
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card ">
            <div class="card-header">
              <h4 class="card-title"> Rooms | <button type="button" class="btn btn-success btn-sm " data-toggle="modal" data-target="#createRoomModal" @click= "createRoom()">Add room</button></h4>

            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table tablesorter " id="">
                  <thead class=" text-primary">
                    <tr>
                      <th></th>
                      <th>
                        Room name
                      </th>
                      <th>
                        Type
                      </th>
                      <th class="text-center">
                        Options
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="room in rooms">
                      <td class="text-center">

                        <img class="avatar"  v-bind:src="'/uploads/' + room.image ">
                        <avatar-cropper
                            @uploading="handleUploading"
                            @uploaded="handleUploaded"
                            @completed="handleCompleted"
                            @error="handlerError"
                            :trigger="'#pick-avatar-'+room.id"
                            :upload-url="'/api/rooms/image/'+ room.id"
                             />
                      </td>
                      <td>
                        {{room.name}}
                      </td>
                      <td>
                        {{getRoomType(Number(room.room_type_id))}}
                      </td>

                      <td class="text-center">
                        <button type="button" class="btn btn-warning btn-sm" name="button" data-toggle="modal" data-target="#createRoomModal"
                        @click=" editRoom(room)" > <i class="fa fa-edit"></i> </button>
                        <button type="button" class="btn btn-danger btn-sm" name="button"
                        @click=" deleteRoom(room.id)" > <i class="fa fa-trash"></i> </button>
                        <button type="button" :id="'pick-avatar-'+room.id" class="btn btn-primary btn-sm pick-avatar" name="button"
                         @click="uploadImg('/api/rooms/image', room.id)"> <i class="fa fa-image"></i> </button>
                      </td>
                    </tr>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        </div>
      </div>
      <footer-nav></footer-nav>
      <!-- edit Room modal -->
      <div class="modal fade editRoom" id="createRoomModal" tabindex="-1" role="dialog" aria-labelledby="EditRoom" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle" v-show="this.form_mode == 'edit'">Edit Room</h5>
              <h5 class="modal-title" id="exampleModalCenterTitle" v-show="this.form_mode == 'create'">Create Room</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form>
                  <input type="hidden" name="id" id="id" v-model="room.id">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Room name</label>
                      <input type="text" class="form-control"  placeholder="Room name" v-model = "room.name" required>
                    </div>
                  </div>

                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Type</label>
                      <select class="form-control" name="room_type_id" v-model="room.room_type_id" required>
                        <option :value="this.room.room_type_id" v-show="this.form_mode == 'edit'">{{this.roomTypeName}} </option>
                        <option v-for="roomType in roomTypes" :value="roomType.id">{{roomType.name}}</option>

                      </select>
                    </div>
                  </div>
                </div>

              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button"  class="btn btn-primary" @click="updateRoom()" v-show="this.form_mode == 'edit'">Save changes</button>
              <button type="button"  class="btn btn-primary" @click="saveRoom()" v-show="this.form_mode == 'create'">Save</button>
            </div>
          </div>
        </div>
      </div>
      <!-- end edit Room modal  -->

  </div>
</div>
</template>
<script>
import axios from 'axios'
import AvatarCropper from "vue-avatar-cropper"
export default {
  components: {
    AvatarCropper
  },
  data(){
    return {
        rooms : [],
        hotel : {},
        room : {},
        roomTypes : [],
        roomTypeName : 'Default',
        form_mode : 'create',
        upload_url: '',
        labels : {submit : "Save" , cancel: "Cancel"}

    }
  },
  mounted: function mounted() {
    this.getHotel()
    this.getRoomTypes()
  },
  methods: {
    //get the hotel details
    getHotel: function getHotel(){
      var id = this.$route.params.hotel_id
      const _this = this
      axios.get(`/api/hotels/${id}`).then(function (response) {

        _this.hotel = response.data.hotel

        //get all rooms in the hotel
        _this.rooms = response.data.rooms;

      });

    },
    //update the hotel
    updateHotel: function updateHotel(){
      axios.patch(`/api/hotels/${this.hotel.id}`, this.hotel).then(response => {

            //update the hotel
            this.getHotel();
            //notify user
            this.notify("Changes saved", "success")
        })
    },
    createRoom: function createRoom(){
      this.form_mode = "create"
    },
    //save room details for hotel
    saveRoom: function saveRoom(){
      this.room.hotel_id = this.hotel.id
      axios.post(`/api/rooms/`, this.room).then(response => {
            this.resetForm();
            //notify user
            this.notify("Room added", "success")
        })
    },
    editRoom: function editRoom(room){
      this.form_mode = "edit"
      this.room = room;

      this.roomTypeName = this.getRoomType(Number(this.room.room_type_id))
    },
    //edit the room details
    updateRoom: function updateRoom(){
      var id =this.hotel.id
      axios.patch(`/api/rooms/${this.room.id}`, this.room).then(response => {
        console.log(response.data)
            //update the rooms table
            this.resetForm();

            this.notify("Changes saved", "success")
        })
    },
    deleteRoom: function deleteRoom(room){
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value) {
          axios.delete(`/api/rooms/${room}`).then(response => {
            this.getHotel()
            this.notify("Room deleted", "danger")
          });
        }
      })

    },
    getRoomTypes: function getRoomTypes() {
      var _this = this;

      axios.get('/api/roomtypes').then(function (response) {

        _this.roomTypes = response.data;

      });
    },
    getRoomType: function getRoomType(id){
      const roomTypes = this.roomTypes
      let result = roomTypes.find((obj) =>  obj.id === id)
      return result.name
    },
    notify : function notify(message, type){
      //notify user
      $.notify({
        // options
        message: message
      },{
        // settings
        type: type
      });
    },
    resetForm: function resetForm(){

      //close modal
      $('#createRoomModal').modal('hide')
      this.getHotel()
      this.room = {}

    },
    handleUploading(form, xhr) {
      this.message = "uploading...";
    },
    handleUploaded(response) {
      if (response.status == "success") {
        this.user.avatar = response.url;
        // Maybe you need call vuex action to
        // update user avatar, for example:
        // this.$dispatch('updateUser', {avatar: response.url})
        this.message = "user avatar updated.";
      }
    },
    handleCompleted(response, form, xhr) {
      this.getHotel()
    },
    handlerError(message, type, xhr) {
      this.message = "Oops! Something went wrong...";
    },
    uploadImg: function uploadImg(url, id){

      this.upload_url = url +'/'+ id

    }
  },
  beforeRouteEnter (to, from, next) {
      let token = localStorage.getItem('jwt')

      axios.defaults.headers.common['Content-Type'] = 'application/json'
      axios.defaults.headers.common['Authorization'] = 'Bearer ' + token

      axios.post('/api/auth/me').then(response => {
      }).catch(error =>{
        if(error.response.status == 401){
          console.log(error.response.status)
          return next('/login')
        }
      })
      next()

    }
}
</script>
