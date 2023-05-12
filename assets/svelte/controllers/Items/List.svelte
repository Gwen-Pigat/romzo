<script>
    import Icon from "../Icon.svelte";
    import FaEdit from 'svelte-icons/fa/FaEdit.svelte'
    import IoMdAddCircle from 'svelte-icons/io/IoMdAddCircle.svelte'
    import { handleState } from "../index";

    export let items
    export let paths = {"addItem": undefined, "handleItemState": undefined}

    let error = null

</script>

<a href="{paths.addItem}" role="button" class="contrast outline add_item">
    <Icon color="#fff"><IoMdAddCircle /></Icon> Ajouter un item
</a>
{#if items}
    <h2>Liste des items</h2>
    {#if error !== null}
        <div class="warning">{error}</div>
    {/if}
    <div id="gridItems" class="grid">
        <table>
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Image</th>
                    <th scope="col">Ordre</th>
                    <th scope="col">Actif</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            {#each items as item,k}
                <tr>
                    <td>{item.id}</td>
                    <td>{item.name}</td>
                    <td>
                        {#if item.image}
                            <img src="{item.image}" alt="{item.name}" width="150" loading="lazy" />
                        {/if}
                    </td>
                    <td>{#if item.placement}{item.placement}{/if}</td>
                    <td>
                        <fieldset>
                            <label for="switch-state-{item.id}">
                                <input on:click={handleState(paths.handleItemState+"?id="+item.id, this)} class="checkbox" type="checkbox" id="switch-state-{item.id}" name="switch-state[{item.id}]" role="switch" checked="{item.isActive}" />
                            </label>
                        </fieldset>
                    </td>
                    <td>
                        <a href="{paths.addItem}/{item.id}" role="button" class="contrast outline sm">
                            <Icon color="#fff" w="15" h="15"><FaEdit /></Icon>
                        </a>
                    </td>
                </tr>
            {/each}
            </tbody>
        </table>
    </div>
{/if}

<style>
    h2{
        margin-bottom: 1rem;
    }
    .add_item{
        float: right;
    }
    .checkbox{
        margin-top: 1rem;
    }
</style>