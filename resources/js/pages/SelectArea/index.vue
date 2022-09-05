<template>
    <div>
        <navbar :user-name="userName"></navbar>
        <Menu :admin="roleId==1"></Menu>

        <div class="container-fluid mt-4">
            <div class="row justify-content-center">
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-header text-white" style="background-color: #00AA9E;">Select Area</div>

                        <div class="container my-3">
                            <div class="form-group mb-3">
                                <label for="ward_id">Select Ward</label>
                                <select class="form-control" v-model="ward_id" autofocus :disabled="office_id">
                                    <option v-for="ward in wardListLocal" :key="ward.id" :value="ward.id">
                                        {{ward.ward_name}}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="office_id">Select Office</label>
                                <select class="form-control" v-model="office_id" autofocus :disabled="ward_id">
                                    <option v-for="office in officeListLocal" :key="office.id" :value="office.id">
                                        {{office.office_name}}
                                    </option>
                                </select>
                            </div>

                            <button class="btn btn-primary" @click="saveWard" :disabled="!office_id && !ward_id">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {ref, toRef} from 'vue'
    import Navbar from '../../components/Navbar'
    import Menu from '../../components/Menu'

    export default {
        name: "SelectArea",

        setup(props) {
            const wardListLocal = ref(toRef(props, 'wardList').value)
            const officeListLocal = ref(toRef(props, 'officeList').value)
            const ward_id = ref(null)
            const office_id = ref(null)

            async function saveWard() {
                if(office_id.value) {
                    window.location.href = '/area?office_id=' + office_id.value
                } else if(ward_id.value) {
                    window.location.href = '/area?ward_id=' + ward_id.value
                }
            }

            return {
                ward_id,
                office_id,
                wardListLocal,
                officeListLocal,
                saveWard
            }
        },

        props: {
            userName: String,
            wardList: {
                type: Array,
                default: () => []
            },
            officeList: {
                type: Array,
                default: () => []
            },
            roleId: {
                type: Number,
                default: 3
            }
        },

        components: {
            Navbar, Menu
        },
    }
</script>