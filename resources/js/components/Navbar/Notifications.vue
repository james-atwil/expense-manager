<template>
  <div class="d-inline-block dropdown nav-item nav-item-notifications">
    <button id="btn-bell" class="btn btn-bell btn-link text-white" data-bs-toggle="dropdown">
      <i class="far fa-bell fa-lg"></i>
      <i class="dot"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-end m-0 p-0 border-0">
      <div class="card card-notifications">
        <div class="card-header">Notifications</div>
        <div class="card-body">message</div>
        <div class="card-footer">See More</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Notifications"
}
</script>
