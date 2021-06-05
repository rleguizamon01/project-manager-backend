<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;

class ProjectController extends Controller
{   
    /**
     * @OA\Get(
     *     path="/api/projects",
     *     tags={"project"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     description="Displays a listing of projects",
     *     operationId="index",
     * )
     */

    public function index()
    {
        $query = Project::query();

        if (request()->filled('search')){
            $query->where('project_name', 'like', '%'.request()->query('search').'%');
        }

        $query->with('userManager', 'userAssigned')->orderBy('created_at', 'ASC');     
                
        return response()->json($query->paginate(10)->withQueryString());
    }

    /**
     * @OA\Post(
     *     path="/api/projects",
     *     tags={"project"},
     *     description="Stores a new project",
     *     operationId="store",
     *     @OA\Response(
     *         response=404,
     *         description="Error not found",
     *     ),
     *     @OA\RequestBody(
     *         description="Input data format",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="project_name",
     *                     description="Name of the new project",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     description="Description of the new project",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="manager_id",
     *                     description="Id of the manager of the new project",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="assigned_id",
     *                     description="Id of the assigned user of the new project",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="enabled",
     *                     description="Status of the new project",
     *                     type="boolean"
     *                 )
     *             )
     *         )
     *     )     
     * )
     */
    public function store(ProjectRequest $request)
    { 
        Project::create($request->all());

        return response()->json([
            'data' => 'Proyecto creado'
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/projects/{projectId}",
     *     tags={"project"},
     *     description="Displays a specific project",
     *     operationId="show",
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *     ),
     *     @OA\Parameter(
     *         name="projectId",
     *         in="path",
     *         description="ID of project to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     )
     * )
     */
    public function show(Project $project)
    {
        return response()->json($project->load('userManager', 'userAssigned'));
    }

    /**
     * @OA\Put(
     *     path="/api/projects/{projectId}",
     *     tags={"project"},
     *     description="Updates a specific project",
     *     operationId="update",
    *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     )
     *     @OA\Parameter(
     *         name="projectId",
     *         in="path",
     *         description="ID of project to edit",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Input data format",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="project_name",
     *                     description="Updated name of the project",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     description="Updated description of the project",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="manager_id",
     *                     description="Updated id of the manager of the project",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="assigned_id",
     *                     description="Updated id of the assigned user of the project",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="enabled",
     *                     description="Updated status of the project",
     *                     type="boolean"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $project->update($request->all());

        return response()->json([
            'data' => 'Proyecto editado'
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/projects/{projectId}",
     *     tags={"project"},
     *     description="Deletes a specific project",
     *     operationId="delete",
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Parameter(
     *         name="projectId",
     *         in="path",
     *         description="ID of project to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     )
     * )
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return response()->json([
            'data' => 'Proyecto eliminado'
        ]);
    }
}
