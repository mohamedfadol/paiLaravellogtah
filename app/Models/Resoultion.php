<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Board;
use App\Models\Committee;
class Resoultion extends Model
{
    use HasFactory;
    protected $table = 'resoultions';
    protected $guarded = ['id'];
    
    protected $casts = [
        'date' => 'datetime',
        'committee_id' => 'integer',
        'board_id' => 'integer',
        'add_by' => 'integer',
        'meeting_id' => 'integer',
        'business_id' => 'integer',
    ];

    
    /**
     * Get the active boards model (boards).
    */
    
    public static function getBoardsResoultion()
    {
        return Resoultion::whereNotNull('board_id')->with(['business','user','meeting',
            'board' => function($q){ return $q->with(['business','members' => function($e){return $e->with(['position',
            'signature_member'=> function($e){return $e->with(['member' => function($e){return $e->with('position','minute_signature_member');}]);},]);}])->active();}
            ]);

    }
    
    
    /**
     * Get the active boards model (boards).
    */
    
    public static function getCommitteesResoultion()
    {
        return Resoultion::whereNotNull('committee_id')->with(['business','user','meeting',
            'committee'=> function($q){ 
                return $q->with([
                                    'board' => function($q){ return $q->with('business');},
                                    'members' => function($e){return $e->with('position');}
                                ]);
                
            }
            ]);

    }
    
    
    public function signatures() {
        return $this->hasMany(Signature::class, 'resoultion_id');
    }
    
    public function business() {
        return $this->belongsTo(Business::class);
    }
    
    public function committee()
    {
        return $this->beLongsTo(Committee::class, 'committee_id');
    }

    public function board()
    {
        return $this->beLongsTo(Board::class, 'board_id');
    }
    
        
    public function user()
    {
        return $this->belongsTo(User::class, 'add_by');
    }
    
        
    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id');
    }
}
