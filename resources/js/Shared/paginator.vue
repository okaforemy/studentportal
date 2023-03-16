<template>
    <!-- paginator -->
                <nav aria-label="..." class="ml-4 mt-4" >
                    <ul class="pagination">
                        <li class="page-item" :class="{active : link.active, disabled : link.url ==null }" v-for="(link,index) in links" :key="index">
                        <Link  :href="link.url"  preserve-scroll  v-html="link.label" class="page-link" />
                        </li>
                    </ul>
                </nav>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'
export default {
    props: {
        links: Array
    },
    components:{
        Link
    }
}
</script>