<template>
  <div class="container px-4 pt-4 ">
    <div class="row pt-5 bg-light">
      <div class="col-md-4 col-12 pt-5">
        <br />
        <br />
        <br />
        <br />
        <div class="row pt-4">
          <div
            class="col-md-3 col-4" style="border-radius:50%;height:110px;width:110px;"
          ><img alt="Vue logo" rounded="circle" src="@/assets/image/user-avatar.png" width="110px" height='110px'>
          </div>
          <div class="col-md-9 col-6 pt-2">
            <h2 id="account-name-label">Alex Nyago</h2>
            <span id="account-role-label">Administrator</span>
          </div>
        </div>
      </div>
      <div class="col-md-7 col-12 pt-3 pb-2">
        <div class style="border:1px solid #eee;">
          <div class="p-4 border-bottom">
            <label class="pl-2" style="font-size:23px;">Your Details</label>
          </div>
          <form class="p-4" style="background-color:#fff;">
            <div class="row pl-3 pr-3 text-left">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="account-fn">First Name</label>
                  <input class="form-control" type="text" id="account-fn" value required />
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="account-ln">Other Names</label>
                  <input class="form-control" type="text" id="account-ln" value />
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="account-email">Email Address</label>
                  <input class="form-control" type="email" id="account-email" value required />
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="account-phone">Phone Number</label>
                  <input class="form-control" type="number" id="account-phone" value />
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="account-role">Role</label>
                  <input class="form-control" type="text" id="account-role" />
                </div>
              </div>

              <div class="col-12">
                <hr class="mt-2 mb-3" />
                  <div class="form-group text-right">
                    <button class="btn btn-success" @click="updateCost"><b-icon icon="pencil" ></b-icon> Update Details </button>
                    <div v-if="error" class="alert alert-danger">{{error}}</div>
                    <b-icon v-show="loading" class="ml-2" icon="arrow-clockwise" animation="spin" font-scale="2"></b-icon>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
