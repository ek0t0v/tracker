<template>
    <div>
        <div class="dashboard-header">
            <h1>History</h1>
        </div>
        <TimingList />
    </div>
</template>

<script>
    import TimingList from '../components/Timing/TimingList';

    export default {
        name: 'History',
        components: {
            TimingList,
        },
    };
</script>

<style lang="less" scoped></style>