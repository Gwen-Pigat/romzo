<script>
    import Icon from "./Icon.svelte";
    import FaInstagram from 'svelte-icons/fa/FaInstagram.svelte'
    import FaYoutube from 'svelte-icons/fa/FaYoutube.svelte'

    export let socials
</script>

<div class="socials" style="display: table;margin: auto;">
    {#if socials}
        {#if socials.insta}
            <Icon w="50" h="50" color="#28c223">
                <FaInstagram />
            </Icon>
        {/if}
        {#if socials.yt}
            <Icon w="50" h="50" color="#ff0000">
                <FaYoutube />
            </Icon>
        {/if}
    {/if}
</div>

<style>
    .socials{
        display: table;
        margin: auto;
    }
</style>