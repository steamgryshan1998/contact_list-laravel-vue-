<template>
    <div class="modal-wrapper" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 v-if="!contact.id" class="modal-title">Create Contact</h5>
                <h5 v-else class="modal-title">Edit Contact</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="closeModal"></button>
            </div>
            <form>
            <div class="modal-body">
                <div class="row">
                <div class="col-md-8">
                <div class="mb-3 row">
                    <label for="name" class="col-sm-4 col-form-label">Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" v-model="contact.name" id="name" placeholder="Please enter your name" >
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="email" class="col-sm-4 col-form-label">Email</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" v-model="contact.email" id="email" placeholder="test@domain.com">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="address" class="col-sm-4 col-form-label">Address</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" v-model="contact.address" id="address" placeholder="New Channel Name">
                    </div>
                </div>

                </div>
                <div class="col-md-4">
                    <img src="contact_list.com/public/images/cross.png" alt="" width="150px" height="150px">
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="closeModal">Close</button>
                <button v-if="!contact.id" type="button" class="btn btn-primary" @click.prevent="addPost">Create</button>
                <button v-else type="button" class="btn btn-primary" @click.prevent="editPost"><i class="fas fa-check"></i>Edit</button>
            </div>
        </form>
    </div>
    </div>
    </div>
</template>
<script>

export default {
    props:{
        contacts: {
            type: Array,
            default: [],
        },
        contact: {
            type: Object,
            default: null
        }
    },
    name: "CreateModal",


    data () {
        return {
                name: '',
                email: '',
                address: '',
        };
    },
    methods: {
        closeModal() {
            this.$emit('close');
        },
        addPost() {
            axios
                .post('api/contact',  {
                    name: this.contact.name,
                    email: this.contact.email,
                    address: this.contact.address,

            })
                .then(response => {
                    this.contacts = []

                    this.closeModal()

                })
                .finally(this.loading = false)
        },
        editPost() {

            axios
                .put('api/contact/' + this.contact.id,  {
                    name: this.contact.name,
                    email: this.contact.email,
                    address: this.contact.address,

                })
                .then(response => {
                    this.contacts = []
                    this.closeModal()
                    this.contact.name = this.name;
                    this.contact.email = this.email;
                    this.contact.address = this.address;

                })
                // .finally(this.contact.id = null // fixed bug with button add new after edit
                //     )
        }
    },

    mounted() {
        if(this.contact){
            this.name = this.contact.name;
            this.email = this.contact.email;
            this.address = this.contact.address;
        }
    },


};
</script>

<style scoped>
.modal-wrapper {
    display: flex;
    position: absolute;
    align-items: center;
    right: 0;
    left: 0;
    top: 0;
    bottom: 0;
    justify-content: center;
    background: rgba(64, 64, 64, .4);
}
</style>
