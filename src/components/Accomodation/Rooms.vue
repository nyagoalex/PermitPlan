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
      <b-row class="p-4 mb-5">
        <b-col>
          <div role="tablist" v-for="(room, index) in rooms" :key="index">
            <b-card no-body class="mb-1">
              <b-card-header header-tag="header" class="p-0" role="tab">
                <b-button block v-b-toggle="`accordion-${room.id}`" variant="light" class="text-left">
                <strong class="text-primary">{{room.name.toUpperCase()}}</strong>
                  <span class="when-opened float-right"><b-icon icon="chevron-up"></b-icon></span>
                  <span class="when-closed float-right"><b-icon icon="chevron-down"></b-icon></span>
                </b-button>
              </b-card-header>
              <b-collapse :id="`accordion-${room.id}`" :visible="(`${index}` == 0)" role="tabpanel" >
                <div class="container">
                    <b-table-simple sticky-header >
                    <b-thead head-variant="light">
                      <b-tr>
                        <b-th v-for="(cost, index) in room.costs" :key="index">{{cost.season.name}}</b-th>
                        <b-th>Action</b-th>
                      </b-tr>
                    </b-thead>
                    <b-tbody>
                      <b-tr>
                        <b-th v-for="(cost, index) in room.costs" :key="index">
                        <input type="number" class="form-control" style="min-width:120px;" v-model="cost.amount"></b-th>
                        <b-th><b-button variant="outline-success"  @click="updateCosts(index)">Update</b-button></b-th>
                      </b-tr>
                    </b-tbody>
                    </b-table-simple>
                </div>
              </b-collapse>
            </b-card>
          </div>
        </b-col>
      </b-row>
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
    },
    updateCosts (index) {
      var room = this.rooms[index]
      var costs = room.costs.map(function (cost) {
        return { id: cost.id, amount: cost.amount }
      })

      this.$http.patch('/rooms/' + room.id + '/costs', { costs: costs })
        .then(response => {
          this.toastSuccess('Costs for' + room.name + ' Successfully Updated')
        })
        .catch(errors => {
          this.$swal.fire('Failed!', errors.message, 'error')
        })
    }
  }
}
</script>

<style>
.collapsed > .when-opened,
  :not(.collapsed) > .when-closed {
      display: none;
  }
</style>
