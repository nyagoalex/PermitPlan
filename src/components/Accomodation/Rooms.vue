<template>
    <div class="tab-pane " id="rooms">
      <div class="pt-4">
          <div class="row">
              <div class="col-md-5 col-12">
                  <div class="">
                      <form id="add-room-form">
                          <div class="form-group">
                              <label for="hotert">Add New Room Type </label>
                              <input class="form-control"  style="height: calc(1.5em + 1.5rem + 2px);" type="text"  v-model="name"  :class="{ 'is-invalid': errors.name}">
                              <ul class="list-unstyled invalid-feedback" v-if="errors.name">
                                  <li v-for="(error) in errors.name" :key="error">{{ error }}</li>
                              </ul>
                          </div>
                          <b-overlay :show="loading" rounded opacity="0.6" spinner-small  class="d-inline-block">
                            <b-button variant="outline-success" @click="addRoom" :disabled="loading" >+ Add</b-button>
                          </b-overlay>
                      </form>
                  </div>
              </div>
              <div class="col-md-2 col">

              </div>

              <div class="col-md-5 col-12 pt-4">
              <div class='season m-5 ' v-if="!rooms || !rooms.length"><p class='text-muted p-2'>No Room Types Registered Yet.</p></div>
                 <div class="season mb-3" v-for="(room, index) in rooms" :key="room.id">
                    <div class="row">
                        <div class="col-md-8 ">
                            <div class="d-inline-block icon icon-xs bg-soft-success rounded-circle mr-1">
                            <b-icon icon="emoji-sunglasses" class="d-inline-block text-success"></b-icon> </div>
                            {{room.name}}
                        </div>
                        <div class="col-md-3 text-right">
                            <span style="cursor: pointer;" v-b-tooltip.hover title="Edit Room Type" @click="updateRoom(index)"><b-icon icon="pen"></b-icon></span> <br>
                            <span style="cursor: pointer;" class="text-danger " v-b-tooltip.hover title="Remove Room Type" @click="removeRoom(index)"><b-icon icon="trash"></b-icon></span> </div>
                    </div>
                </div>
              </div>
          </div>
      </div>
  </div>
</template>
<script>

export default {
  data () {
    return {
      loading: false,
      errors: {},
      name: ''
    }
  },
  props: {
    rooms: Array
  },
  methods: {
    addRoom () {
      this.loading = true
      this.errors = {}
      const { name } = this
      this.$http.post('/lodges/' + this.$route.params.id + '/rooms', { name: name })
        .then(response => {
          this.alertAddSuccess()
          this.name = ''
          const { id, name } = response.data.data
          this.rooms.push({ id: id, name: name })
        })
        .catch(errors => {
          this.errors = errors.errors
          this.toastError(errors.message)
        })
        .finally(() => { this.loading = false })
    },
    updateRoom (index) {
      const id = this.rooms[index].id
      this.$swal.fire({
        title: 'Update Room Type',
        input: 'text',
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Update Room',
        reverseButtons: true,
        showLoaderOnConfirm: true
      }).then((result) => {
        if (result.value) {
          this.$http.patch('/lodges/' + this.$route.params.id + '/rooms/' + id, { name: result.value })
            .then(response => {
              this.toastSuccess('Successfully Updated')
              // this.name = ''
              const { id, name } = response.data.data

              this.$set(this.rooms, index, { id: id, name: name })
            })
            .catch(errors => {
              this.$swal.fire('Failed!', errors.message, 'error')
            })
        }
      })
    },
    removeRoom (index) {
      const id = this.rooms[index].id

      this.ConfirmDelete().then((result) => {
        if (result.value) {
          this.$http.delete('/lodges/' + this.$route.params.id + '/rooms/' + id)
            .then(() => {
              this.rooms = this.rooms.filter(item => item.id !== id)
              this.$swal.fire('Deleted!', 'Room has been deleted.', 'success')
            })
            .catch(errors => {
              this.toastError(errors.message)
            })
        }
      })
    }
  }
}
</script>
