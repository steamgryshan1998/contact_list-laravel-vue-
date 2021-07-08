<template>
    <div class="modal-wrapper" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Contact</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="closeModal"></button>
            </div>
            <form>
            <div class="modal-body">
                <div class="mb-3 row">
                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="contact.name" id="name" placeholder="Please enter your name" >
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="contact.email" id="email" placeholder="test@domain.com">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="address" class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="contact.address" id="address" placeholder="New Channel Name">
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="closeModal">Close</button>
                <button type="button" class="btn btn-primary"  @click="addPost">Save changes</button>
            </div>
            </form>
        </div>
    </div>
    </div>
</template>
<script>

export default {
    data () {
        return {
            contacts: [],
            contact: {
                name: '',
                email: '',
                address: '',
            },
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
                    //this.getPosts()
                    //this.closeModal()

                })
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
