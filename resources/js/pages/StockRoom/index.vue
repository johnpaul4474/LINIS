<template>
    <div>
        <navbar :user-name="userName"></navbar>
        <Menu :admin="roleId==1"></Menu>

        <div class="container-fluid mt-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header text-white" style="background-color: #00AA9E;">STOCK ROOMS</div>
                        <div class="card-body">
                            <div class="card p-3 bg-light mb-2">
                                <legend>ADD STOCK ROOM</legend>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">Stock Room</span>                 
                                    <input class="form-control" v-model="new_stock_room" style="text-transform:uppercase" type="text" required autocomplete="stock_room" autofocus>        
                                </div>
                                
                                <br>
                                <div class="d-grid gap-1">
                                    <button type="button" class="btn btn-primary" @click="addStockRoom" :disabled="!new_stock_room || new_stock_room.length == 0">Add Stock Room</button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Stock Room</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(room, index) in stockRoomsLocal" :key="index" :class="selected_stock_room_index == index ? 'table-primary' : ''">
                                            <td>
                                                {{room.stock_room}}
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm ml-1" data-bs-toggle="modal" data-bs-target="#renameStockRoomModal" @click="setCurrentStockRoom(room)">Rename</button>
                                                <button type="button" class="btn btn-danger btn-sm ml-1" :disabled="room.storages.length>0" @click="deleteStockRoom(room)">Delete</button>
                                                <button type="button" class="btn btn-success btn-sm ml-1" @click="selectStockRoom(index)">
                                                    Storage List
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header text-white" style="background-color: #00AA9E;">STORAGES in {{stockRoomsLocal && selected_stock_room_index >= 0 ? stockRoomsLocal[selected_stock_room_index].stock_room : ''}}</div>
                        <div class="card-body">
                            <div class="card p-3 bg-light mb-2">
                                <legend>ADD STORAGE in {{stockRoomsLocal && selected_stock_room_index >= 0 ? stockRoomsLocal[selected_stock_room_index].stock_room : ''}}</legend>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">Storage</span>                 
                                    <input class="form-control" style="text-transform:uppercase" type="text" v-model="new_storage">                  
                                </div>
                                
                                <br>
                                <div class="d-grid gap-1">
                                    <button type="button" class="btn btn-primary" :disabled="!new_storage || new_storage.length == 0" @click="addStorage">Add Storage</button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Storage</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(storage, index) in storages" :key="index" :class="selected_storage_index == index ? 'table-primary' : ''">
                                            <td>
                                                {{storage.storage_name}}
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm ml-1" data-bs-toggle="modal" data-bs-target="#renameStorageModal" @click="setCurrentStorage(storage)">Rename</button>
                                                <button type="button" class="btn btn-danger btn-sm ml-1" :disabled="storage.raw_materials.length>0 || storage.products.length>0" @click="deleteStorage(storage)">Delete</button>
                                                <button type="button" class="btn btn-success btn-sm ml-1" @click="selectStorage(index)">
                                                    View Contents
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header text-white" style="background-color: #00AA9E;">
                            Contents of
                            <span v-if="stockRoomsLocal && stockRoomsLocal.length > 0 && selected_stock_room_index >= 0 && stockRoomsLocal[selected_stock_room_index].storages.length > 0 && selected_storage_index >= 0">
                                {{stockRoomsLocal[selected_stock_room_index].stock_room}}/
                                {{storages[selected_storage_index] ? storages[selected_storage_index].storage_name : ''}}
                            </span>
                        </div>

                        <div class="card-body">
                            <legend>Products & Raw Materials</legend>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Type</th>
                                            <th scope="col">Material</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Unit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in contents" :key="index">
                                            <td>{{item.type}}</td>
                                            <td>{{item.type == "Raw Material" ? item.description : item.product_name}}</td>
                                            <td>{{item.type == "Raw Material" ? item.quantity : item.product_quantity}}</td>
                                            <td>{{item.type == "Raw Material" ? item.unit : item.product_unit}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rename Stock Room Modal -->
        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="renameStockRoomModal" >
            <div class="modal-dialog">
                <div class="modal-content bg-light">
                    <div class="modal-body" v-if="currentStockRoom">
                            <legend>RENAME STOCK ROOM</legend>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">Stock Room</span>                 
                                <input class="form-control" v-model="currentStockRoom.stock_room" style="text-transform:uppercase" type="text" required autocomplete="stock_room" autofocus>        
                            </div>
                            
                            <br>
                            <div class="d-flex">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="renameStockRoom" :disabled="!currentStockRoom.stock_room || currentStockRoom.stock_room.length == 0">Rename</button>
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rename Storage Modal -->
        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="renameStorageModal" >
            <div class="modal-dialog">
                <div class="modal-content bg-light">
                    <div class="modal-body" v-if="currentStorage">
                            <legend>RENAME STORAGE</legend>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">Storage</span>                 
                                <input class="form-control" v-model="currentStorage.storage_name" style="text-transform:uppercase" type="text" required autofocus>        
                            </div>
                            
                            <br>
                            <div class="d-flex">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="renameStorage" :disabled="!currentStorage.storage_name || currentStorage.storage_name.length == 0">Rename</button>
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {ref, computed, toRef} from 'vue'
    import Navbar from '../../components/Navbar'
    import Menu from '../../components/Menu'
    import axios from 'axios';

    export default {
        setup (props) {
            const stockRoomsLocal = ref(toRef(props, 'stockRooms').value)
            const selected_stock_room_index = ref(0)
            const selected_storage_index = ref(0)
            const new_stock_room = ref("")
            const new_storage = ref("")
            const currentStockRoom = ref({})
            const currentStorage = ref({})

            const storages = computed(() => {
                return stockRoomsLocal.value[selected_stock_room_index.value].storages
            })

            const contents = computed(() => {
                var rawMaterials = []
                var products = []

                if(storages.value[selected_storage_index.value]) {
                    rawMaterials = storages.value[selected_storage_index.value].raw_materials
                    products = storages.value[selected_storage_index.value].products
                }

                for(let i=0; i<rawMaterials.length; i++) {
                    rawMaterials[i].type = "Raw Material"
                }

                for(let i=0; i<products.length; i++) {
                    products[i].type = "Product"
                }

                return products.concat(rawMaterials)
            })

            function selectStockRoom(index) {
                selected_stock_room_index.value = index
            }

            function selectStorage(index) {
                selected_storage_index.value = index
            }

            function setCurrentStockRoom(room) {
                currentStockRoom.value = {...room}
            }

            function setCurrentStorage(storage) {
                currentStorage.value = {...storage}
            }

            async function addStockRoom() {
                const res = await axios.post("/stockroom/add", {
                    stock_room: new_stock_room.value
                })

                stockRoomsLocal.value = [res.data, ...stockRoomsLocal.value]
                new_stock_room.value = ""
                selected_stock_room_index.value = 0
            }

            async function renameStockRoom() {
                const res = await axios.post("/stockroom/update", currentStockRoom.value)

                const index = stockRoomsLocal.value.findIndex(room => {
                    return room.id == currentStockRoom.value.id
                })

                stockRoomsLocal.value[index] = res.data
            }

            async function deleteStockRoom(room) {
                const res = await axios.post("/stockroom/delete", {id: room.id})

                const index = stockRoomsLocal.value.findIndex(r => {
                    return r.id == room.id
                })

                stockRoomsLocal.value.splice(index, 1)
            }

            async function addStorage() {
                const res = await axios.post("/stockroom/storage/add", {
                    stock_room_id: stockRoomsLocal.value[selected_stock_room_index.value].id,
                    storage_name: new_storage.value
                })

                stockRoomsLocal.value[selected_stock_room_index.value].storages = [res.data, ...stockRoomsLocal.value[selected_stock_room_index.value].storages]
                new_storage.value = ""
                selected_storage_index.value = 0
            }

            async function renameStorage() {
                const res = await axios.post("/stockroom/storage/update", currentStorage.value)

                const index = storages.value.findIndex(sto => {
                    return sto.id == currentStorage.value.id
                })

                stockRoomsLocal.value[selected_stock_room_index.value].storages[index] = res.data
            }

            async function deleteStorage(storage) {
                const res = await axios.post("/stockroom/storage/delete", {id: storage.id})

                const index = storages.value.findIndex(sto => {
                    return sto.id == storage.id
                })

                stockRoomsLocal.value[selected_stock_room_index.value].storages.splice(index, 1)
            }

            return {
                selectStockRoom,
                selectStorage,
                storages,
                selected_stock_room_index,
                selected_storage_index,
                stockRoomsLocal,
                setCurrentStockRoom,
                setCurrentStorage,
                addStockRoom,
                addStorage,
                new_stock_room,
                new_storage,
                currentStockRoom,
                currentStorage,
                renameStockRoom,
                renameStorage,
                deleteStockRoom,
                deleteStorage,
                contents
            }
        },

        components: {
            Navbar, Menu
        },

        props: {
            userName: String,
            stockRooms: Array,
            roleId: {
                type: Number,
                default: 3
            }
        }
    }
</script>