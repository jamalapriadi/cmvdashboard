<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Add New Sosial Media</div>

                    <div class="card-body">
                        <div v-if="message" class="alert alert-success">
                            {{ message }}
                        </div>

                        <form @submit.prevent="save" action="/sosmed/sosmed" method="post">
                            <div :class="['form-group', errors.name ? 'has-error': '']">
                                <label class="control-label">Sosial Media Name</label>
                                <input class="form-control" name="name" placeholder="Sosial Media Name" v-model="state.name">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary">Save</button>
                                <router-link to="sosmed" class="btn btn-default">
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
                group: [],
                state: {
                    name: ''
                }
            }
        },

        mounted() {
            
        },

        methods: {
            save(e) {
                axios.post(e.target.action, this.state)
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
            }
        }
    }
</script>
