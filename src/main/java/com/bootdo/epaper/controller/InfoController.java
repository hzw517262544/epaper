package com.bootdo.epaper.controller;

import com.bootdo.common.utils.PageUtils;
import com.bootdo.common.utils.Query;
import com.bootdo.common.utils.R;
import com.bootdo.epaper.domain.InfoDO;
import com.bootdo.epaper.service.InfoService;
import org.apache.shiro.authz.annotation.RequiresPermissions;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import java.util.Map;

/**
 * 
 * 
 * @author chglee
 * @email 1992lcg@163.com
 * @date 2018-12-11 20:14:45
 */
 
@Controller
@RequestMapping("/epaper/webBasicInfo")
public class InfoController {
	@Autowired
	private InfoService infoService;
	
	@GetMapping()
//	@RequiresPermissions("system:info:info")
	String Info(Model model){
		List<InfoDO> infoDOS = infoService.list(null);
		if(infoDOS != null&&!infoDOS.isEmpty()){
			model.addAttribute("basicInfo",infoDOS.get(0));
		}
	    return "epaper/Admin/WebBasicInfo";
	}
	
	@ResponseBody
	@GetMapping("/list")
//	@RequiresPermissions("system:info:info")
	public PageUtils list(@RequestParam Map<String, Object> params){
		//查询列表数据
        Query query = new Query(params);
		List<InfoDO> infoList = infoService.list(query);
		int total = infoService.count(query);
		PageUtils pageUtils = new PageUtils(infoList, total);
		return pageUtils;
	}
	
	@GetMapping("/add")
//	@RequiresPermissions("system:info:add")
	String add(){
	    return "system/info/add";
	}

	@GetMapping("/edit/{id}")
	@RequiresPermissions("system:info:edit")
	String edit(@PathVariable("id") Integer id,Model model){
		InfoDO info = infoService.get(id);
		model.addAttribute("info", info);
	    return "system/info/edit";
	}
	
	/**
	 * 保存
	 */
	@ResponseBody
	@PostMapping("/save")
//	@RequiresPermissions("system:info:add")
	public R save( InfoDO info){
		if(infoService.save(info)>0){
			return R.ok();
		}
		return R.error();
	}
	/**
	 * 修改
	 */
	@ResponseBody
	@RequestMapping("/update")
//	@RequiresPermissions("system:info:edit")
	public R update( InfoDO info){
		infoService.update(info);
		return R.ok();
	}
	
	/**
	 * 删除
	 */
	@PostMapping( "/remove")
	@ResponseBody
//	@RequiresPermissions("system:info:remove")
	public R remove( Integer id){
		if(infoService.remove(id)>0){
		return R.ok();
		}
		return R.error();
	}
	
	/**
	 * 删除
	 */
	@PostMapping( "/batchRemove")
	@ResponseBody
//	@RequiresPermissions("system:info:batchRemove")
	public R remove(@RequestParam("ids[]") Integer[] ids){
		infoService.batchRemove(ids);
		return R.ok();
	}
	
}
