<?php

namespace App\Http\Controllers;
use App\Models\Things;
use App\Models\devices;
use Illuminate\Http\Request;
use App\Models\Things_Data;

class SuhuController extends Controller
{
    public function index()
    {
        // Ambil data suhu terbaru dari database
        $latestTemperature = Things_data::latest()->first();
        $thing = Things::where('devices_id', 1)->first();
        

        // Pass data suhu ke view
        return view('IoT', ['value' => $thing->value1 ?? 0], compact('latestTemperature'));
    }

    public function thing(){
        
        $devices = Devices::all();  // Fetch all devices from the database
        $things = Things::all();  

        return view('things', compact('devices', 'things'));
    }

    public function showThings($device_id)
    {
        // Mengambil semua devices untuk dropdown
        $devices = Devices::all();
        
        // Mengambil device berdasarkan id yang dipilih
        $device = Devices::find($device_id);
        
        // Mengambil things yang terkait dengan device yang dipilih
        $things = Things::where('devices_id', $device_id)->get();
        
        // Kirim data device dan things ke view
        return view('things', compact('devices', 'device', 'things'));
    }
    public function getThings($device_id)
    {
        // Ambil semua things berdasarkan device_id
        $things = Things::where('devices_id', $device_id)->get();

        // Ambil nama device
        $device = Devices::find($device_id);
        $deviceName = $device->name;

        // Buat array untuk menyimpan things beserta datanya
        $thingsWithData = [];

        // Untuk setiap thing, ambil data things_data terkait
        foreach ($things as $thing) {
            $thingsData = Things_Data::where('things_id', $thing->id)->orderBy('created_at', 'desc')->get();

            $thingsWithData[] = [
                'things_type' => $thing->things_type,
                'things_data' => $thingsData // Koleksi nilai dari tabel things_datas
            ];
        }

        // Kembalikan JSON response
        return response()->json([
            'deviceName' => $deviceName,
            'things' => $thingsWithData
        ]);
    }  
     public function getSuhuData($device_id)
    {
        // Ambil semua things yang terkait dengan device_id
        $things = Things::where('devices_id', $device_id)->pluck('id');

        // Ambil data suhu dari tabel things_datas
        $suhuData = Things_Data::whereIn('things_id', $things)
            ->orderBy('created_at', 'asc')
            ->select('value as suhu', 'created_at as time')
            ->get();
        
        // Format waktu ke detik
        $suhuData->transform(function($data) {
            $data->time = $data->time->format('H:i:s'); // Format sesuai dengan kebutuhan Anda
            return $data;
        });

        return response()->json([
            'suhu' => $suhuData
        ]);
    }

public function getDataForChart()
    {
        // Ambil data things dari database
        $thingsData = Things::select('value1', 'value2', 'created_at')
                            ->where('devices_id', 1) // Filter by devices_id
                            ->orderBy('created_at', 'ASC')
                            ->get();

        // Kirim data ke view untuk ditampilkan di chart
        return response()->json($thingsData);
    }


    public function device()
    {
        // Mengambil data dari tabel devices dan things terkait
        $devices = Devices::with('things')->get();  // Asumsikan relasi sudah diatur
        return view('devices', compact('devices'));
    }

      // Method to toggle the power (ON/OFF)
     public function updatePowerStatus(Request $request)
    {
        // Update status pada tabel Things
        $thing = Things::where('devices_id', 1)->first(); // Sesuaikan devices_id
        if ($thing) {
            $thing->status = $request->status;
            $thing->save();

            return response()->json([
                'message' => 'Power status updated successfully!'
            ]);
        }

        return response()->json([
            'message' => 'Device not found.'
        ], 404);
    }

    // Function untuk set thermometer value
    public function setThermometer(Request $request)
    {
        $request->validate([
            'value1' => 'required|numeric',
            'device_id' => 'required|integer|exists:devices,id'
        ]);

        $device = devices::find($request->device_id);

        if ($device) {

            foreach($device->things as $item){
                $item->value_set = $request->input('value1');

                $item->save();
            }

            return response()->json(['message' => 'Temperature set successfully.']);
        }

        return response()->json(['message' => 'Device not found.'], 404);
    }

    // Method to toggle the power status
    public function togglePower(Request $request)
    {

        // return $request;
        $request->validate([
            'status' => 'required|boolean',
            'device_id' => 'required|integer|exists:devices,id'
        ]);

        $device = devices::find($request->device_id);

        if ($device) {
            
            foreach($device->things as $item){
                $item->status = $request->input('status');

                $item->save();
            }

            return response()->json(['status' => $device->things[0]->status, 'message' => 'Power status updated.']);
        }

        return response()->json(['message' => 'Device not found.'], 404);
    }

    // Method to get the current power status
    public function getPowerStatus(Request $request)
    {
        $request->validate([
            'device_id' => 'required|integer|exists:devices,id'
        ]);

        $device = devices::find($request->device_id);


        if ($device) {
            return response()->json(['status' => $device->things[0]->status]);
        }

        return response()->json(['message' => 'Device not found.'], 404);
    }


public function getLaporanData($device_id)
{
    // Mengambil data things berdasarkan device_id
    $thingsData = Things_Data::where('device_id', $device_id)->get();
    
    // Mengembalikan data dalam format JSON
    return response()->json([
        'things_data' => $thingsData
    ]);
}

public function getChartData($deviceId)
{
    $things = Things::where('devices_id', $deviceId)->with('things_data')->get();

    $chartData = [];
    foreach ($things as $thing) {
        $thingData = [];
        foreach ($thing->things_data as $data) {
            $thingData[] = [
                'value' => $data->value,
                'timestamp' => $data->created_at
            ];
        }

        $chartData[] = [
            'label' => $thing->things_type, // Name of the thing
            'data' => $thingData
        ];
    }

    return response()->json($chartData);
}






}



