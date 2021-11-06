<template>
  <app-layout title="وسایل">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">وسایل</h2>
    </template>

    <div class="py-12 row g-2">
      <div class="p-4 mr-4 bg-white shadow-xl col-2 sm:rounded-lg">
        <div v-for="location in locations" :key="location.id" class="flex border-b-2 border-gray-200">
          <div @click="showDescendantof(location.id)" class="me-auto" style="cursor: Pointer">
            <p style="cursor: Pointer">{{ location.name }}</p>
          </div>
          <div @click="oppenCreateLocation(location.id)" >
            <i
              class="text-gray-300 fas fa-plus-circle"
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

export default defineComponent({
  components: {
    AppLayout,
    Link,
  },
  props: {
    devices: Object,
    locations: Object,
  },
  setup(props) {
    const devices = reactive(props.devices);
    const locations = reactive(props.locations);

    const formLocation = reactive({
      name: null,
      parent_id: null,
    });

    let createLocation = ref(false);

    function oppenCreateLocation(id) {
      createLocation.ref = true;
      formLocation.parent_id = id;
    }

    function clossCreateLocation() {
      createLocation.ref = false;
      formLocation.parent_id = null;
    }

    function showDescendantof(id) {
      console.log(id);
    }

    return {
      devices,
      locations,
      oppenCreateLocation,
      clossCreateLocation,
      showDescendantof,
    };
  },
});
</script>
