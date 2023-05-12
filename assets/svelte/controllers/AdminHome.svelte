<script>

    import { ListItems } from "./Items";
    import { ListItemsSpecs } from "./ItemsSpecs";

    export let user

    export let items

    export let itemsSpecs
    export let paths


    export let error = null
    export async function handleState(path, event){
        event.setAttribute("disabled", "")
        const response = await fetch(path, {
            method: 'GET',
        });
        const result = await response.json();
        if(result.data.error){
            error = result.data.error
        }
        event.removeAttribute("disabled")
    }
    $: {
        error
    }

</script>

<h1>Bonjour {user}</h1>
{#if items}
    <ListItems {items} {paths} />
{/if}
{#if itemsSpecs}
    <ListItemsSpecs {itemsSpecs} {paths} />
{/if}