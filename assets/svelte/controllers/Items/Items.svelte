<script>
    import Icon from "../Icon.svelte";
    import FaSearchPlus from 'svelte-icons/fa/FaSearchPlus.svelte'
    import FaYoutube from 'svelte-icons/fa/FaYoutube.svelte'

    export let item
    export let paths

    let error = null
    let specs = null

    async function getSpecs(path, event)
    {
        event.setAttribute("disabled", "disabled")
        const response = await fetch(path, {
            method: 'GET',
        });
        const result = await response.json();
        event.removeAttribute("disabled")
        error = null;
        specs = null
        if(result.data.error){
            error = result.data.error
        } else{
            console.log(document.getElementsByClassName("blocSpecs"))
            for(let i = 0; i < document.getElementsByClassName("blocSpecs").length; i++){
                console.log(document.getElementsByClassName("blocSpecs")[i])
                document.getElementsByClassName("blocSpecs")[i].innerHtml = ""
            }
            specs = result.data
            console.log(specs.length)
        }
    }

    $:{
        error
        specs
        console.log(specs)
    }

</script>

<div class="item">
    <h3 class="title">{item.name} {#if item.scoreTotal}<small class="score_total">Score total de {item.scoreTotal}</small>{/if}</h3>
    {#if item.score}<small class="score_total">({item.score} points sur les critères demandés)</small>{/if}
    {#if item.image}
        <div class="image" style="background-image: url({item.image})"></div>
    {/if}
    <div class="grid">
        {#if item.youtubeLink}
            <a href="{item.youtubeLink}" target="_blank" role="button" class="primary">
                <Icon>
                    <FaYoutube />
                </Icon>
                Voir la vidéo associée
            </a>
        {/if}
        <button class="contrast" data-results="results-{item.id}" data-tooltip="Cliquez afin de voir les spécificitées techniques" on:click={getSpecs(paths.specsItems+"?id="+item.id,this)}>
            <Icon color="#fff">
                <FaSearchPlus />
            </Icon>
        </button>
    </div>
    {#if specs}
        <div class="blocSpecs">
            <h3 class="title">Spécificités techiques</h3>
            {#if specs.length <= 0}
                <div class="warning">Aucune spécificité n'a été précisé pour ce modèle</div>
            {:else}
                <table>
                    <tbody>
                        {#each specs as spec}
                            <tr>
                                <th scope="row">{spec.name}</th>
                                <td class="value value-{spec.value}">{spec.value}</td>
                            </tr>
                        {/each}
                    </tbody>
                </table>
            {/if}
        </div>
    {/if}
    {#if error}
        <div class="warning">{error}</div>
    {/if}
</div>

<style>
    .value{
        font-weight: bold;
    }
    .value-1{
        color: #ff0000;
    }
    .value-2{
        color: orange;
    }
    .value-3{
        color: yellow;
    }
    .value-4{
        color: green;
    }
    .value-5{
        color: #28c223;
    }
    .blocSpecs{
        margin-top: 3rem;
    }
    .blocSpecs .title{
        margin-bottom: 0.4rem;
    }
    .item{
        padding: 1rem;
        color: #fff;
        background-color: rgba(255,255,255,0.8);
        box-shadow: 1px 1px 10px 1px #333;
        border-radius: 0.4rem;
        margin-bottom: 1rem;
        transition-duration: 0.4s;
    }
    .score_total{
        font-size: 0.8rem;
        margin-left: 3rem;
    }
    .grid button{
        margin: 0;
    }
    .grid a{

    }
    .item .image{
        margin: 1rem auto;
        background-size: cover;
        height: 350px;
        width: 100%;
        background-position: center center;
        //filter: blur(4px);
        transition-duration: 0.4s;
    }
    .item:hover{
        transform: scale(1.01);
        transition-duration: 0.4s;
    }
    .item .title{
        text-align: center;
        margin-bottom: 0.4rem;
    }
    .item a{
        display: block;
        text-decoration: none;
    }
    .item a:hover{
        transition-duration: 0.4s;
        opacity: 0.6;
    }
</style>