<script>
    export let color="#000"

    export let w="25"
    export let h="25"

</script>

<div class="icon" style="--color:{color};--width:{w}px;--height:{h}px;">
    <slot></slot>
</div>

<style>
    .icon{
        color: var(--color);
        width: var(--width);
        height: var(--height);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        position: relative;
        top: 4px;
    }
</style>