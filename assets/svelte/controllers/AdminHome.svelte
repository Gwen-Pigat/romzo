<script>

    import { ListItems } from "./Items";
    import { ListItemsSpecs } from "./ItemsSpecs";

    export let user

    export let items

    export let itemsSpecs
    export let paths

</script>

<h1>Bonjour {user}</h1>
{#if items}
    <ListItems {items} {paths} />
{/if}
{#if itemsSpecs}
    <ListItemsSpecs {itemsSpecs} {paths} />
{/if}