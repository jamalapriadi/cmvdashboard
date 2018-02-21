<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Sosial Media</div>

                    <div class="panel-body">
                        <div v-if="message" class="alert alert-success">
                            {{ message }}
                        </div>

                        <form @submit.prevent="save" method="post">
                            <div class="form-group">
                                <label class="control-label">Sosial Media Name</label>
                                <input class="form-control" name="name" placeholder="Sosial media Name" v-model="state.name">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary">Save</button>
                                <router-link to="/sosmed" class="btn btn-default">
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
                message: '',
                error:[],
                state: {
                    name:''
                },
                group: []
            }
        },

        mounted() {
            const url = `/sosmed/sosmed/${this.$route.params.id}`;

            axios.get(url)
                .then(response => {
                    this.group = response.data;
                    this.notFound = false;
                    this.state.name = response.data.sosmed_name;
                }).catch(error => {
                    if(error.response.status == 404){
                        this.notFound = true;
                        this.message = error.response.data.message;
                    }
                })
        },

        methods: {
            save(e) {
                axios.put(`/sosmed/sosmed/${this.$route.params.id}`, this.state)
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
