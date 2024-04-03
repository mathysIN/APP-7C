<div class="mx-auto my-8 max-w-4xl px-4 md:px-0">
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Mes devis</h1>
        <a href="/devis"><button class="ring-offset-background focus-visible:ring-ring hover:bg-primary/90 inline-flex h-10 items-center justify-center whitespace-nowrap rounded-md bg-eventit-500 px-4 py-2 text-sm font-medium text-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50"> Nouveau devis </button>
        </a>
    </div>
    <div class="relative w-full overflow-auto">
        <table class="w-full caption-bottom text-sm">
            <thead class="[&amp;_tr]:border-b">
                <tr class="hover:bg-muted/50 data-[state=selected]:bg-muted border-b transition-colors">
                    <th class="text-muted-foreground h-12 px-4 text-left align-middle font-medium"> Date </th>
                    <th class="text-muted-foreground h-12 px-4 text-left align-middle font-medium"> Référence </th>
                    <th class="text-muted-foreground h-12 px-4 text-left align-middle font-medium"> Nombre de capteurs </th>
                    <th class="text-muted-foreground h-12 px-4 text-left align-middle font-medium"> Montant </th>
                    <th class="text-muted-foreground h-12 px-4 text-left align-middle font-medium"> État du paiement </th>
                    <th class="text-muted-foreground h-12 px-4 text-left align-middle font-medium"> État du devis </th>
                </tr>
            </thead>
            <tbody class="[&amp;_tr:last-child]:border-0">
                <tr class="hover:bg-muted/50 data-[state=selected]:bg-muted border-b transition-colors">
                    <td class="p-4">21/12/23 18h57</td>
                    <td class="p-4 font-medium text-eventit-500">78643258</td>
                    <td class="p-4">2</td>
                    <td class="p-4">32,87€</td>
                    <td class="p-4">
                        <div class="focus:ring-ring hover:bg-secondary/80 inline-flex w-fit items-center whitespace-nowrap rounded-full border border-transparent bg-green-500 px-2.5 py-0.5 text-xs font-semibold text-white transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2"> Payé </div>
                    </td>
                    <td class="[&amp;:has([role=checkbox])]:pr-0 p-4 align-middle">
                        <div class="focus:ring-ring hover:bg-primary/80 inline-flex w-fit items-center whitespace-nowrap rounded-full border border-transparent bg-yellow-500 px-2.5 py-0.5 text-xs font-semibold text-white transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2"> En cours </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>