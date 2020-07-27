<template>
    <div class="tab-pane " id="rooms">
      <div class="pt-4">
          <div class="row">
              <div class="col-md-5 col-12">
                  <div class="">
                      <form id="add-room-form">
                          <div class="form-group">
                              <label for="hotert">Add New Room Type </label>
                              <input class="form-control"  style="height: calc(1.5em + 1.5rem + 2px);" type="text" id="l-room" required>
                          </div>
                          <b-button variant="outline-success" onclick="addRoom(this)">+ Add</b-button>
                      </form>
                  </div>
              </div>
              <div class="col-md-2 col">

              </div>

              <div class="col-md-5 col-12 pt-4" id="rooms-tb">
              </div>
          </div>
      </div>
  </div>
</template>
