class ClientAttachment extends Model
{
    protected $fillable = ['filename','url'];
    public function client() { return $this->belongsTo(Client::class); }
}