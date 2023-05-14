<script>
    import Items from "./Items/Items.svelte";
    import Socials from "./Socials.svelte";

    export let socials
    export let items

    export let paths


</script>

<Socials {socials} />

<a href="{paths.quiz}" class="primary" role="button">Faire le quiz</a>

{#if items}
    <div id="itemsList">
        {#each items as item}
                <Items {item} {paths} />
        {/each}
    </div>
{/if}

<style>
    .primary{
        margin: 3rem 0;
        width: 100%;
        display: block;
        border-radius: 0;
    }
    #itemsList{
        margin: 1rem 0;
    }
</style>