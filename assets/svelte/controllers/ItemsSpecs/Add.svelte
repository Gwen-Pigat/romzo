<script>
    export let fields
    export let path
    export let title

    let error = null
    let success = null

    async function handleSubmit(event){
        const data = new FormData(this)
        const response = await fetch(event.currentTarget.getAttribute("data-path"), {
            method: 'POST',
            body: data
        });
        const result = await response.json();
        if(result.data.error){
            error = result.data.error
        } else{
            success = result.data.message
        }
        if(result.data.url){
            let timer = 0
            if(result.data.url.timer){
                timer = result.data.url.timer
            }
            setTimeout(function(){
                window.location.href = result.data.url.value
            },timer);
        }
    }
    $: {
        error;
        console.log(error)
    }

</script>

<h1>{title}</h1>
{#if success !== null}
    <div class="success">{success}</div>
{:else}
    <form on:submit|preventDefault={handleSubmit} data-path="{path}">
        {#if !fields}
            AUcun champ n'a pu être récupéré
        {/if}
        {#each fields as field}
            {@html field}
        {/each}
        <button type="submit">Ajouter la spécificité</button>

        {#if error !== null}
            <div class="error">{error}</div>
        {/if}
    </form>
{/if}