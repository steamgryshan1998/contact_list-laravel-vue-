<template>
    <div>
        <div>
            <header class="mb-3 border-bottom">
                <div class="row">
                    <div class="col-11 title">
                        <h3 class="main_header">Contact-list - {{ timestamp }}</h3>
                    </div>
                    <div class="dropdown profile text-end col-1 row">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle profile_header" type="button"
                                    id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <a href="#">
                                    <img src="1.jpg" alt="mdo" width="33" height="33" class="rounded-circle">
                                </a>
                                Profile
                            </button>
                        </div>
                    </div>
                </div>
                <hr>
            </header>
        </div>
        <div class="container border-css mt-5">
            <div class="header">
                <h1 class="col name">Contacts</h1>
                <div class="col-2">
                    <button type="button" class="btn contact_button btn-primary " @click="showCreateModal">
                        <!--                todo font awesome-->
                        <i class="bi bi-person-plus">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-person-plus" viewBox="0 0 16 16">
                                <path
                                    d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                <path fill-rule="evenodd"
                                      d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                            </svg>
                        </i>Add new
                    </button>
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-danger del align-middle contact_button" @click="deleteMarked">
                        <i class="bi bi-person-x">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-person-x" viewBox="0 0 16 16">
                                <path
                                    d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                <path fill-rule="evenodd"
                                      d="M12.146 5.146a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z"/>
                            </svg>
                        </i>Delete marked
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-10">
                    <table class="table table-bordered">
                        <tr>
                            <td scope="col">
                                <input type="checkbox" class="checkall"
                                       :checked="checkedAll"
                                       @change="checkAll($event.target.checked)">
                            </td>
                            <td></td>
                            <td class="col-lg-3" scope="col">
                                <div
                                    @click="sortBy('name')"
                                    style="cursor: pointer">
                                    Name
                                    <i class="fas fa-sort"></i>
                                </div>

                            </td>
                            <td class="col-lg-3" scope="col">
                                <div
                                    @click="sortBy('email')"
                                    style="cursor: pointer">
                                    Email
                                    <i class="fas fa-sort"></i>
                                </div>

                            </td>
                            <td class="col-lg-3" scope="col">
                                <div
                                    @click="sortBy('address')"
                                    style="cursor: pointer">
                                    Address
                                    <i class="fas fa-sort"></i>
                                </div>
                            </td>
                            <td class="col-lg-3" scope="col">
                                <div
                                    @click="sortBy('updated_at')"
                                    style="cursor: pointer">
                                    Created at
                                    <i class="fas fa-sort"></i>
                                </div>
                            </td>
                            <td scope="col"></td>
                        </tr>
                        <tr v-for="contact in contacts" :key="contact.id">
                            <td scope="col">
                                <input
                                    type="checkbox"
                                    class="thing"
                                    v-on:click="contact.checked = !contact.checked" :checked="contact.checked"
                                >
                            </td>
                            <td><i class="far fa-window-close"></i></td>
                            <td><a href="#">{{ contact.name }}</a></td>
                            <td>{{ contact.email }}</td>
                            <td>{{ contact.address }}</td>
                            <td>{{ moment(contact.updated_at).fromNow() }}</td>
                            <td>
                                <TheDropdown
                                    :contact="contact"
                                    @viewContact="editPost(contact)"
                                    @deleteContact="DeletePost(contact.id)"
                                />
                            </td>
                        </tr>

                    </table>
                </div>
                <div class="col-sm-2">

                </div>
            </div>
        </div>
        <div>
        </div>
        <CreateModal
            v-show="isCreateModalVisible"
            @close="closeCreateModal"
            :contacts="contacts"
            :contact="deskProp"
        />
        <!--        <DeleteModal-->
        <!--            v-show="isDeleteModalVisible"-->
        <!--            @close="closeDeleteModal"-->
        <!--        />-->

    </div>
</template>

<script>
import CreateModal from "./CreateModal";
import TheDropdown from "./TheDropdown";


export default {
    components: {
        TheDropdown,
        CreateModal,
    },
    data() {
        return {
            contacts: [],
            checkedAll: false,
            sort: {
                name: true,
                email: true,
                address: true,
                updated_at: true,
            },
            contact: {
                id: '',
                name: '',
                email: '',
                address: '',
                updated_at: ''
            },
            deskProp: {},
            errored: false,
            isCreateModalVisible: false,
            timestamp: new Date().getFullYear()
        };
    },
    created() {
        setInterval(this.nowDate, 1000);
    },
    computed: {
        isChecked() {
            let tmpBool = false;
            let k = 0;
            this.contacts.forEach(i => {
                if (i.checked) {
                    tmpBool = true;
                    k++;
                }
            });
            if (!tmpBool) this.checkedAll = false;
            this.checkedAll = (k === this.contacts.length);
            return !tmpBool;
        }
    },
    methods: {
        showCreateModal() {
            this.isCreateModalVisible = true;
        },
        closeCreateModal() {
            this.isCreateModalVisible = false;
            this.getPosts();
        },
        getPosts() {
            axios
                .get("api/contact")
                .then(response => {
                    this.contacts = response.data
                })
                .catch(error => {
                    console.error(error)
                    this.errored = true;
                })
                .finally(() => this.loading = false)
            this.contacts.forEach(i => {
                i.checked = false;
            });

        },
        nowDate: function () {
            let today = new Date();
            let date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
            let time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            let dateTime = date + ' ' + time;
            this.timestamp = dateTime;
        },
        editPost(contact) {
            console.log(contact);

            this.deskProp = contact;
            this.isCreateModalVisible = true;
        },

        checkAll(checked) {
            this.checkedAll = true;
            this.contacts.forEach(i => {
                i.checked = checked;
            })
        },


        DeletePost(id) {
            axios
                .post('api/contact/' + id, {
                    _method: 'DELETE'
                })
                .then(response => {
                    this.contacts = []
                    this.getPosts();
                })
                .catch(error => {
                    console.log(error)
                    this.errored = true
                })

        },
        deleteMarked() {
            let n = 0;
            this.contacts.forEach(i => {
                if (i.checked) {
                    axios.delete('api/contact/' + i.id)
                        .then(response => {
                            this.getPosts();
                        })
                    n++;
                }
            })
            if (n === 0) {
                this.getPosts();
            }
            this.contacts = this.contacts.filter(i => i.checked === false);
        },
        sortBy(field) {
            this.contacts = this.contacts.sort(compare(field, this.sort[field]));
            this.sort[field] = !this.sort[field];
        },
    },
    mounted() {
        this.getPosts()
    },
};

function compare(field, isAscending = true) {
    return function (a, b) {
        let type = typeof (a[field]);
        if (type === 'number')
            if (isAscending)
                return a[field] - b[field];
            else
                return b[field] - a[field];
        else {
            if (isAscending) {
                if (a[field] < b[field]) return -1;
                if (a[field] > b[field]) return 1;
                return 0;
            } else {
                if (a[field] > b[field]) return -1;
                if (a[field] < b[field]) return 1;
                return 0;
            }
        }
    }
}
</script>
<style scoped>
header {
    margin: 0;
    padding-bottom: 0;
    padding-top: 1rem !important;
    padding-right: 1rem !important;
    padding-left: 1rem !important;
}

.main_header {
    font-family: var(--bs-font-sans-serif);
    /*font-family: 'Lato', sans-serif;*/
    color: white;
    font-size: 1rem;
}

.profile_header {
    background-color: #7F4C00;
}

hr {
    border: 1px solid white;
}

.title {
    padding-top: calc(var(--bs-gutter-x) * .5);
    margin-left: 12px;
}

.profile {
    padding-left: 0;
}

.container {
    min-width: 1600px;
}

.border-css {
    border: 2px solid;
    border-radius: 10px;
}

table {
    color: #a79294;
    border-color: #e6e1e5;
}


.contact_button {
    margin-top: 1rem;
    margin-left: 4.5rem;

}

.header {
    display: flex;
    padding-bottom: 0;
}

.name {
    font-size: 1.5rem;
    margin-bottom: 0;
    padding-top: 1rem;
    padding-left: 1rem;
}

i {
    padding-left: 10px;
    margin-right: 10px;
}


.btn-primary.add {
    margin-left: 900px;
}

.far,
.fas {
    margin-right: 7px;
}

.fa-sort {
    padding-left: 50px;
}

.table-title {
    font-size: 30px;
}
</style>


