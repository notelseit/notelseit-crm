public function index(Request $request)
{
    $query = Client::query();
    if ($request->ragione_sociale_like)
        $query->where('ragione_sociale', 'LIKE', '%'.$request->ragione_sociale_like.'%');
    if ($request->settore_like)
        $query->where('settore', 'LIKE', '%'.$request->settore_like.'%');
    // Paginazione e ordinamento possono essere gestiti anche qui
    return $query->get();
}

public function show($id)
{
    return Client::with(['contacts','leads','activities','offers','attachments'])->findOrFail($id);
}

// Gestione allegati
public function storeAttachment(Request $request, $id)
{
    $client = Client::findOrFail($id);
    $file = $request->file('file');
    $path = $file->store('client_attachments');
    $attachment = $client->attachments()->create([
        'filename' => $file->getClientOriginalName(),
        'url' => Storage::url($path)
    ]);
    return $attachment;
}