<template>
    <div>
        <Toolbar />
        <router-view />
        <AppFooter />
        <CreateEditQuestion />
    </div>
</template>

<script>
import Toolbar from './Toolbar';
import AppFooter from './AppFooter';
import CreateEditQuestion from './modal/CreateEditQuestion';

export default {
    components: { Toolbar, AppFooter, CreateEditQuestion }
}
</script>