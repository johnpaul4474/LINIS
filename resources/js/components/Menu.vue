<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="/home">Home</a></li>
                    <a class="nav-link" href="/departments" role="button" v-if="admin">Wards & Offices</a>

                    <li class="nav-item dropdown" v-if="admin">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Inventory Management
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/material">Raw Materials</a></li>
                            <li><a class="dropdown-item" href="/products">Add Final Product </a></li>
                            <li><a class="dropdown-item" href="/stockroom">Storage Management</a></li>
                        </ul>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Issuance and Condemned
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/issuance" v-if="admin">Issue Finished Products</a></li>
                            <li><a class="dropdown-item" href="/returnedProducts">Condemned/Return Products</a></li>
                        </ul>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Request Management
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">                
                            <li><a class="dropdown-item" href="/request">Create Request</a></li>
                            <li><a class="dropdown-item" href="/services">Services</a></li>
                            <li><a class="dropdown-item" href="/reports">Reports</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown" v-if="admin">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Role Management
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">                
                            <li><a class="dropdown-item" href="/users/roleManagement">Assign Employee</a></li>
                            <li><a class="dropdown-item" href="/users/listusers">List of users</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    props: ["admin"]
}
</script>