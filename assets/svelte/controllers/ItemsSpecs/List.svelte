<script>
    export let itemsSpecs
    console.log(itemsSpecs)
    export let paths = {
        "addItemSpec": undefined
    }
</script>

<a href="{paths.addItemSpec}">Ajouter un spécificité technique</a>

{#if itemsSpecs}
    {#each itemsSpecs as itemSpec}
        <a href="{paths.addItemSpec}/{itemSpec.id}">{itemSpec.name}</a>
    {/each}
{/if}