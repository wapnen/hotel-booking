<template>
<div class="wrapper">
<sidebar title = "Rooms"></sidebar>
  <div class="main-panel">
    <!-- Navbar -->
    <navigation title = "Rooms"></navigation>
    <!-- End Navbar -->
    <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card ">
            <div class="card-header">
              <h4 class="card-title"> Rooms</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table tablesorter " id="">
                  <thead class=" text-primary">
                    <tr>
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
                    <tr v-for="Room in Rooms">
                      <td>
                        {{Room.name}}
                      </td>
                      <td>
                        {{Room.city}} , {{Room.state}}, {{Room.country}}
                      </td>
                      <td>
                        {{Room.email}}
                      </td>
                      <td class="text-center">
                        {{Room.phone}}
                      </td>
                      <td>
                        <button type="button" class="btn btn-warning" name="button" data-toggle="modal" data-target="#editRoomModal"
                        @click=" editRoom(room.id, room.name, room.type)" >Edit</button>
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
      <div class="modal fade editRoom" id="editRoomModal" tabindex="-1" role="dialog" aria-labelledby="EditRoom" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle">Edit Room</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form>
                  <input type="hidden" name="id" id="id" v-model="id">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Room name</label>
                      <input type="text" class="form-control"  placeholder="Room name" v-model = "name" required>
                    </div>
                  </div>

                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Type</label>
                      <select class="form-control" name="type" v-model="type">
                        <option value="Deluxe">Deluxe</option>
                        <option value="Standard">Standard</option>
                      </select>
                    </div>
                  </div>
                </div>

              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button"  class="btn btn-primary" @click="updateRoom()">Save changes</button>
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
export default {
  data(){
    return {
        rooms : [],
        id : '',
        name : '',
        type : '',

    }
  },
  mounted: function mounted() {
    this.getRooms();
  },
  methods: {
    getRooms: function getRooms() {
      var _this = this;

      axios.get('/api/Rooms').then(function (response) {
        _this.Rooms = response.data;

      });
    },
    editRoom: function editRoom(id, name, type){
      this.id = id;
      this.name = name;
      this.type = type;
    },
    updateRoom: function updateRoom(){
      axios.put(`api/Rooms/${this.id}`, {name: this.name, type: this.type}).then(response => {
            console.log(response.data)
            //update the table
            this.getRooms();
            //close modal
            $('#editRoomModal').modal('hide')
            //notify user
            $.notify({
            	// options
            	message: 'Changes saved'
            },{
            	// settings
            	type: 'success'
            });
        })
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
          return next('login')
        }
      })
      next()

    }
}
</script>
