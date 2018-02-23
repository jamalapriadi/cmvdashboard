<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Add New Program Unit</div>

                    <div class="card-body">
                        <div v-if="message" class="alert alert-success">
                            {{ message }}
                        </div>

                        <form @submit.prevent="save" action="/sosmed/program-unit" method="post">
                            <div :class="['form-group', errors.name ? 'has-error': '']">
                                <label class="control-label">Business Unit</label>
                                <select class="form-control" name="unit" v-model="state.unit">
                                    <option value="" disabled selected>--Select Unit--</option>
                                    <option v-for="g in unit" v-bind:value="g.id">{{ g.unit_name }}</option>
                                </select>
                            </div>
                            
                            <div :class="['form-group', errors.name ? 'has-error': '']">
                                <label class="control-label">Program Name</label>
                                <input class="form-control" name="name" v-model="state.name">
                            </div>

                            <fieldset>
                                <legend>Sosial Media</legend>
                                <div class="form-group" v-for="(s,index) in sosmed">
                                    <label class="control-label">{{ s.sosmed_name }} Account</label>
                                    <input class="form-control"  v-model="state.sosmed[s.id]" :placeholder="s.sosmed_name">
                                </div>
                            </fieldset>

                            <hr>

                            <div class="form-group">
                                <button class="btn btn-primary">Save</button>
                                <router-link to="program-unit" class="btn btn-default">
                                    Back
                                </router-link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                errors: [],
                unit: [],
                message:'',
                sosmed: [],
                state: {
                    group:'',
                    name: '',
                    sosmed: {}
                }
            }
        },

        mounted() {
            this.listUnit();
            this.listSosmed();
        },

        methods: {
            save(e) {
                axios.post(e.target.action, this.state)
                    .then(response => {
                        this.state = {
                            name: '',
                            unit: '',
                            sosmed: {}
                        }

                        this.errors = {'name' : response.data.error[0] };

                        if ( response.data.success = true) {
                            this.message = response.data.pesan;
                        } else {
                            this.message = response.data.pesan;
                        }
                    }).catch(error => {
                        if (! _.isEmpty(error.response)) {
                            if (error.response.state = 422) {
                                this.errors = error.response.data;
                            }
                        }
                    })
            },

            listUnit(){
                axios.get('/sosmed/list-unit')
                    .then(response => {
                        this.unit = response.data;
                    }).catch(error => {
                        if (! _.isEmpty(error.response)){
                            if (error.response.state = 442) {
                                this.errors = error.response.data;
                            }
                        }
                    })
            },

            listSosmed(){
                axios.get('/sosmed/list-sosmed')
                    .then(response => {
                        this.sosmed = response.data;
                    }).catch(error => {
                        if (! _.isEmpty(error.response)){
                            if (error.response.state = 442) {
                                this.errors = error.response.data;
                            }
                        }
                    })
            }
        }
    }
</script>

<style>
    fieldset{
        border: 1px solid #ddd !important;
        margin: 0;
        xmin-width: 0;
        padding: 10px;       
        position: relative;
        border-radius:4px;
        background-color:#f5f5f5;
        padding-left:10px!important;
    }	

    legend{
        font-size:14px;
        font-weight:bold;
        margin-bottom: 0px; 
        width: 35%; 
        border: 1px solid #ddd;
        border-radius: 4px; 
        padding: 5px 5px 5px 10px; 
        background-color: #d8dfe5;
        color:#222;
    }
</style>
