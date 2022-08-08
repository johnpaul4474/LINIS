<template>
    <div>
        <navbar :user-name="userName"></navbar>
        <Menu></Menu>

        <div class="container mt-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header text-white" style="background-color: #00AA9E;">STOCK ROOMS</div>
                        <div class="card-body">
                            <div class="card p-3 bg-light mb-2">
                                <legend>ADD STOCK ROOM</legend>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">Stock Room</span>                 
                                    <input class="form-control" style="text-transform:uppercase" type="text" required autocomplete="stock_room" autofocus>        
                                </div>
                                
                                <br>
                                <div class="d-grid gap-1">
                                    <button type="button" class="btn btn-primary" href='material/add'>Add Stock Room</button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Stock Room</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(room, index) in stockRooms" :key="index" :class="selected_storage_index == index ? 'table-success' : ''">
                                            <td>
                                                {{room.stock_room}}
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm ml-1">Edit</button>
                                                <button type="button" class="btn btn-danger btn-sm ml-1">Delete</button>
                                                <button type="button" class="btn btn-success btn-sm ml-1" @click="selectStorageRoom(index)">
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
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header text-white" style="background-color: #00AA9E;">STORAGES in {{selected_storage_index >= 0 ? stockRooms[selected_storage_index].stock_room : ''}}</div>
                        <div class="card-body">
                            <div class="card p-3 bg-light mb-2">
                                <legend>ADD STORAGE in {{selected_storage_index >= 0 ? stockRooms[selected_storage_index].stock_room : ''}}</legend>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">Storage</span>                 
                                    <input class="form-control" style="text-transform:uppercase" type="text" required autocomplete="storage" autofocus>                  
                                </div>
                                
                                <br>
                                <div class="d-grid gap-1">
                                    <button type="button" class="btn btn-primary" href='material/add'>Add Storage</button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Storage</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(storage, index) in storages" :key="index">
                                            <td>
                                                {{storage.storage_name}}
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm ml-1">Edit</button>
                                                <button type="button" class="btn btn-danger btn-sm ml-1">Delete</button>
                                                <button type="button" class="btn btn-success btn-sm ml-1">View Contents</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {ref, computed} from 'vue'
    import Navbar from '../components/Navbar'
    import Menu from '../components/Menu'

    export default {
        setup (props) {
            const selected_storage_index = ref(0)

            const storages = computed(() => {
                return props.stockRooms[selected_storage_index.value].storages
            })

            function selectStorageRoom(index) {
                selected_storage_index.value = index
            }

            return {selectStorageRoom, storages, selected_storage_index}
        },

        components: {
            Navbar, Menu
        },

        props: {
            userName: String,
            stockRooms: Array
        }
    }
</script>