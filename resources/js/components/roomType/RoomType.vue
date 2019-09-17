<template>
<div class="wrapper">
<sidebar title = "Room type"></sidebar>
  <div class="main-panel">
    <!-- Navbar -->
    <navigation title = "Room type"></navigation>
    <!-- End Navbar -->
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card ">
            <div class="card-header">
              <h4 class="card-title"> Room types | <button type="button" class="btn btn-success btn-sm " data-toggle="modal" data-target="#createRoomTypeModal" @click= "createRoomType()">Add room type</button> </h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table tablesorter " id="">
                  <thead class=" text-primary">
                    <tr>
                      <th>
                        Name
                      </th>
                      <th class="text-center">
                        Options
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="roomType in roomTypes">
                      <td>
                        {{roomType.name}}
                      </td>


                      <td class="text-center">
                        <button type="button" class="btn btn-warning btn-sm" name="button" data-toggle="modal" data-target="#createRoomTypeModal"
                        @click=" editRoomType(roomType)"  > <i class="fa fa-edit"></i> </button>
                        <button type="button" class="btn btn-danger btn-sm" name="button" data-toggle="modal" data-target="#editHotelModal"
                        @click=" deleteRoomType(roomType)"  > <i class="fa fa-trash"></i> </button>
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
      <!-- edit hotel modal -->
      <div class="modal fade editRoomType" id="createRoomTypeModal" tabindex="-1" role="dialog" aria-labelledby="EditHotel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle" v-show="this.form_mode == 'edit'">Edit Room Type</h5>
              <h5 class="modal-title" id="exampleModalCenterTitle" v-show="this.form_mode == 'create'">Create Room Type</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form>
                  <input type="hidden" name="id" id="id" v-model="roomType.id">

                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Room type</label>
                          <input type="text" class="form-control"  placeholder="e.g Deluxe" v-model = "roomType.name" required>
                        </div>
                      </div>
                    </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button"  class="btn btn-primary" @click="updateRoomType()" v-show="this.form_mode == 'edit'">Save changes</button>
              <button type="button"  class="btn btn-primary" @click="saveRoomType()" v-show="this.form_mode == 'create'">Save</button>
            </div>
          </div>
        </div>
      </div>
      <!-- end edit hotel modal  -->
  </div>
</div>
</template>
<script>
import axios from 'axios'
export default {
  data(){
    return {
        roomTypes : [],
        roomType: {},
        id : '',
        name : '',
        form_mode : 'create',
    }
  },
  mounted: function mounted() {
    this.getRoomTypes();
  },
  methods: {
    getRoomTypes: function getRoomTypes() {
      var _this = this;

      axios.get('/api/roomtypes').then(function (response) {
        console.log(response.data)
        _this.roomTypes = response.data;

      });
    },
    createRoomType: function createRoomType(){
      this.form_mode = "create"
    },
    saveRoomType: function saveRoomType(){
      axios.post(`/api/roomtypes`, {name: this.roomType.name}).then(response => {
        this.resetForm()
        this.notify("Room type added ", "success")
      })
    },
    editRoomType: function editRoomType(roomType){
      this.roomType = roomType
      this.form_mode = "edit"
    },
    updateRoomType: function updateRoomType(){
      axios.put(`api/roomtypes/${this.roomType.id}`, this.roomType).then(response => {
            console.log(response.data)
            this.resetForm()
            this.notify("Changes saved", "success")
        })
    },
    deleteRoomType: function deleteRoomType(roomType){
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
          axios.delete(`api/roomtypes/${roomType.id}`).then(response => {
            this.getRoomTypes()
            this.notify("Room type deleted", "danger")
          });
        }
      })

    },
    resetForm: function resetForm(){
      this.roomType = {}
      this.getRoomTypes()
      $('#createRoomTypeModal').modal('hide')
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
  },

  beforeRouteEnter (to, from, next) {
      let token = localStorage.getItem('jwt')

      axios.defaults.headers.common['Content-Type'] = 'application/json'
      axios.defaults.headers.common['Authorization'] = 'Bearer ' + token

      axios.post('/api/auth/me').then(response => {
      }).catch(error =>{
        if(error.response.status == 401){
          console.log(error.response.status)
          return next('login')
        }
      })
      next()

    }
}
</script>
