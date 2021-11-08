<template>
  <app-layout title="وسایل">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">وسایل</h2>
    </template>

    <div class="py-12 row g-2">
      <div class="p-4 mr-4 bg-white shadow-xl col-2 sm:rounded-lg">
        <div
          v-for="location in locations"
          :key="location.id"
          class="flex border-b-2 border-gray-200"
        >
          <div
            @click="showDescendantof(location.id)"
            class="me-auto"
            style="cursor: Pointer"
          >
            <p style="cursor: Pointer">{{ location.name }}</p>
          </div>
          <div class="mx-2">
            <i class="text-gray-300 fas fa-shopping-basket"
            style="cursor: Pointer"
            ></i>
          </div>
          <div @click="oppenCreateLocation(location.id)">
            <i
              class="text-gray-300 fas fa-map-marker-alt"
              style="cursor: Pointer"
            ></i>
          </div>
        </div>
      </div>
      <div class="col-9 sm:px-6 lg:px-8">
        <div class="mx-auto bg-white shadow-xl sm:rounded-lg">
          <ul>
            <li v-for="device in devices.data" :key="device.id">
              {{ device.name }}
            </li>
          </ul>
          <div
            v-if="devices.links.length > 3"
            class="flex flex-row justify-center"
          >
            <p
              v-for="(link, key) in devices.links"
              :key="key"
              class="flex p-0 m-0"
            >
              <Link
                v-if="key == 0"
                :href="link.url"
                class="p-3 text-white bg-red-500 border border-gray-400 rounded-r-lg hover:text-yellow-100 hover:bg-red-700 hover:border-double focus:text-red-300 focus:bg-red-900"
              >
                &laquo;
              </Link>
              <Link
                v-if="
                  key != 0 && key != devices.links.length - 1 && !link.active
                "
                :href="link.url"
                class="p-3 text-white bg-red-500 border border-gray-400 hover:text-yellow-100 hover:bg-red-700 hover:border-double focus:text-red-300 focus:bg-red-900"
              >
                {{ link.label }}
              </Link>
              <Link
                v-if="link.active"
                :href="link.url"
                class="p-3 text-red-300 bg-red-900 border border-gray-400"
                isabled
              >
                {{ link.label }}
              </Link>
              <Link
                v-if="key == devices.links.length - 1"
                :href="link.url"
                class="p-3 text-white bg-red-500 border border-gray-400 rounded-l-lg hover:text-yellow-100 hover:bg-red-700 hover:border-double focus:text-red-300 focus:bg-red-900"
              >
                &raquo;
              </Link>
            </p>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import { defineComponent, reactive, ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
import Swal from "sweetalert2";

export default defineComponent({
  components: {
    AppLayout,
    Link,
    Swal,
  },
  props: {
    devices: Object,
    locations: Object,
  },
  data() {
    return {
      formLocation: this.$inertia.form({
        name: "",
        parent_id: "",
      }),
      result: true,
    };
  },
  methods: {
    alertCreateLocation() {
      Swal.fire({
        title: "نام مکان را وارد کنید",
        input: "text",
        inputAttributes: {
          autocapitalize: "off",
        },
        showCancelButton: true,
        confirmButtonText: "افزودن",
        cancelButtonText: "لغو",
        showLoaderOnConfirm: true,
        preConfirm: (name) => {
          return this.sendCreatLoction(name);
        },
        allowOutsideClick: () => !Swal.isLoading(),
      });
    },
    sendCreatLoction(name) {
      this.formLocation.name = name;
      this.formLocation.post(this.route("Location.create"), {
        onError: (errors) => {
          Swal.fire({
            icon: "error",
            title: "خطاا!!!",
            text: errors.name,
            showConfirmButton:true,
            showCancelButton: true,
            cancelButtonText: "باشد",
            confirmButtonText: "برگشت",
            preConfirm: () => {
          return this.alertCreateLocation();
        },
          });
        },
        onSuccess: () => {
          Swal.fire({
            icon: "success",
            title: "با موفقیت افزوده شد.",
            showConfirmButton:true,
            confirmButtonText: "باشد",
          });
          this.showDescendantof(this.formLocation.parent_id);
        },
      });
    },
  },
  setup(props) {
    const devices = reactive(props.devices);
    const locations = reactive(props.locations);

    let createLocation = ref(false);
    let showId = ref(null);

    function oppenCreateLocation(id) {
      createLocation.value = true;
      this.formLocation.parent_id = id;
      this.alertCreateLocation();
    }

    function clossCreateLocation() {
      createLocation.value = false;
      formLocation.parent_id = null;
    }

    function showDescendantof(id) {
      showId.value = id;
      axios
        .get(`/location/show/${id}`)
        .then(function (response) {
          // handle success
          console.log(response);
        })
        .catch(function (error) {
          // handle error
          console.log(error);
        })
        .then(function () {
          // always executed
        });
    }

    return {
      devices,
      locations,
      oppenCreateLocation,
      clossCreateLocation,
      showDescendantof,
      createLocation,
      showId,
    };
  },
});
</script>
