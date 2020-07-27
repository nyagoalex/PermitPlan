<template>
  <div class="tab-pane" id="activities">
    <div class="pt-4">
        <div class="row">

            <div class="col-md-5 col-12">

                <div class="">

                    <form id="add-activity-form">
                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label for="l-activity">Add New Activity </label>
                                <input class="form-control" type="text" id="l-activity" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="l-activity">Activity Price P/P </label>
                                <input class="form-control" type="text" id="l-activity" required>
                            </div>
                        </div>

                        <b-button variant="outline-success" onclick="addActivity(this)">+ Add</b-button>

                    </form>
                </div>
            </div>
            <div class="col-md-2 col">
            </div>

            <div class="col-md-5 col-12 pt-4" id="activities-tb">
                <div class='rooms mb-3'><p class='text-muted p-2'>No Activities Types Registered Yet.</p></div>
            </div>
        </div>
    </div>

    <br>
    <div class="pt-5">
        <h5>Hotel/Lodge Facilities</h5>
        <hr>
    </div>
    <div class="pt-4">

        <div class="row">

            <div class="col-md-5 col-12">

                <div class="">

                    <form id="add-facility-form">
                        <div class="form-group">
                            <label for="l-facility">Add a facility </label>
                            <input class="form-control" type="text" id="l-facility" value="" required>
                        </div>

                        <b-button variant="outline-success" onclick="addFacility(this)">+ Add</b-button>

                    </form>

                </div>

            </div>

            <div class="col-md-2 col">

            </div>

            <div class="col-md-5 col-12 pt-4" id="facilities-tb">
                <div class='rooms mb-3'><p class='text-muted p-2'>No Facilities Types Registered Yet.</p></div>
            </div>
        </div>
    </div>
  </div>
</template>
