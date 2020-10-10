<template>
    <div class="col-md-4 col-sm-12 pl-2">
        <div class="card notif-card mr-4" style="height:575px; overflow-y: auto;">
            <div class="card-header">
                <!-- Title -->
                <h4 class="card-header-title">
                    <b-icon icon="bell-fill" class="mr-2"></b-icon> Urgent Reminders
                </h4>
            </div>
            <div class="row text-center pt-3 px-3 border-bottom" v-for="n in 10" :key="n">
                <div class="col-md-2">
                    <b-icon width="40" height="40" class="rounded-circle bg-success" variant="secondary"></b-icon>
                </div>
                <div class="col-md-8">
                    <strong>Dianna Smiley</strong><br>
                    <span class="card-text small">
                        <span class="text-success"><b style="font-size:15px;">4</b><small>x</small></span> <span>Permits</span> on <span><b>23rd Sep 2017</b></span>
                    </span><br>
                    <small class="text-muted">Permits need top up</small>
                </div>
                <div class="col-md-2">
                    <b-button size="sm" pill variant="outline-primary"> View</b-button>
                </div>
            </div>

        </div>
    </div>
</template>

<style>
.notif-card .card-header {
    border: 0px;
    background-color: #fd397a1a;
}

.notif-card .card-header-title {
    color: #c70039;
    font-size: 20px;
}
</style>
