<template>
    <span :class="[
        'inline-block px-2 py-1 rounded text-xs font-medium min-w-[60px] text-center',
        statusClass
    ]">
        {{ status }}
    </span>
</template>

<script>
export default {
    props: {
        status: String
    },
    computed: {
        statusClass() {
            switch (this.status) {
                case "PENDING":
                    return "bg-yellow-50 text-yellow-600";
                case "COMPLETED":
                    return "bg-green-50 text-green-600";
                case "IN_PROGRESS":
                    return "bg-blue-50 text-blue-600";
                case "CANCELLED":
                    return "bg-red-50 text-red-500";
                default:
                    return "bg-gray-50 text-gray-600";
            }
        }
    }
};
</script>