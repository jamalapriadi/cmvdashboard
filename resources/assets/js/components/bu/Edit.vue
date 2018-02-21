<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Add New Business Unit</div>

                    <div class="panel-body">
                        <div v-if="message" class="alert alert-success">
                            {{ message }}
                        </div>

                        <form @submit.prevent="save">
                            <div :class="['form-group', errors.name ? 'has-error': '']">
                                <label class="control-label">Group Name</label>
                                <select class="form-control" name="group" v-model="state.group">
                                    <option value="" disabled selected>--Select Group--</option>
                                    <option v-for="g in group" v-bind:value="g.id">{{ g.group_name }}</option>
                                </select>
                            </div>
                            
                            <div :class="['form-group', errors.name ? 'has-error': '']">
                                <label class="control-label">Business Unit Name</label>
                                <input class="form-control" name="name" v-model="state.name">
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary">Save</button>
                                <router-link to="/business-unit" class="btn btn-default">
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
                notFound: false,
                errors: [],
                group: [],
                unit: [],
                message: '',
                state: {
                    group:'',
                    name: ''
                }
            }
        },

        mounted() {
            const url = `/sosmed/business-unit/${this.$route.params.id}`;
            this.listGroup();

            axios.get(url)
                .then(response => {
                    this.unit = response.data;
                    this.notFound = false;
                    this.state.group = response.data.group_unit_id;
                    this.state.name = response.data.unit_name;
                }).catch(error => {
                    if ( error.response.status == 404){
                        this.notFound = true;
                        this.message = error.response.data.message;
                    }
                })
        },

        methods: {
            save(e) {
                axios.put(`/sosmed/business-unit/${this.$route.params.id}`, this.state)
                    .then(response => {
                        this.state = {
                            name: ''
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

            listGroup(){
                axios.get('/sosmed/list-group')
                    .then(response => {
                        this.group = response.data;
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
