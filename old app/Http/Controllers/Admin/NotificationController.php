<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;

class NotificationController extends Controller
{
    public function index(Request $request)
    { 
        $notifications = Notification::orderBy("id","desc")->get();
        return view('admin.notifications.index', compact('notifications'));
    }
     
    public function create()
    {
        return view('admin.notifications.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,svg',
            'description' => 'required',
        ]);
        $imageName = rand(1111,9999) . time().'.'.$request->image->extension();  
     
        $request->image->move(public_path('images'), $imageName);

        Notification::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imageName,
        ]);
     
        $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();
          
        $SERVER_API_KEY = 'XXXXXX';
  
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->description,  
            ]
        ];
        $dataString = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);

        return redirect()->route('admin.notification.index')->with('success','Notification created successfully.');
    }
     
    public function edit(Notification $notification)
    {
        return view('admin.notifications.edit',compact('notification'));
    }
    
    public function update(Request $request, Notification $Notification)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg',
            'description' => 'required',
        ]);

        $NotificationArr = [
            'title' => $request->title,
            'description' => $request->description,
        ];

        if($request->hasFile('image'))
        {
            $imageName = rand(1111,9999) . time().'.'.$request->image->extension();  
            $request->image->move(public_path('images'), $imageName);     
            $NotificationArr['image'] = $imageName;                    
        } 
        
        $Notification->update($NotificationArr);
    
        return redirect()->route('admin.notification.index')->with('success','Notification updated successfully');
    }
    
    public function destroy(Notification $Notification)
    {
        $Notification->delete();
    
        return redirect()->route('admin.notification.index')->with('success','Notification deleted successfully');
    }
}
